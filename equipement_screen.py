from kivy.uix.screenmanager import Screen
from kivy.uix.boxlayout import BoxLayout
from kivy.uix.label import Label
from kivy.uix.button import Button
from kivy.uix.scrollview import ScrollView
from kivy.uix.gridlayout import GridLayout
from kivy.uix.spinner import Spinner
from kivy.uix.textinput import TextInput
from kivy.graphics import Color, RoundedRectangle, Rectangle
from kivy.uix.widget import Widget
from kivy.core.window import Window
from kivy.uix.popup import Popup
from kivy.uix.anchorlayout import AnchorLayout

from equipement_widget import EquipementWidget
from database import Database

class EquipementScreen(Screen):
    def __init__(self, **kwargs):
        super().__init__(**kwargs)
        self.db = Database()

        with self.canvas.before:
            Color(0.87, 0.94, 0.97, 1)
            self.bg_rect = Rectangle(size=self.size, pos=self.pos)
        self.bind(size=self._update_bg, pos=self._update_bg)

        root = BoxLayout(orientation='vertical', padding=10, spacing=10)

        navbar = BoxLayout(size_hint=(1, 0.1), spacing=10)
        logo = Label(text="Airblio", font_size=24, bold=True, color=(0.13, 0.62, 0.74, 1), size_hint=(None, 1), width=100)
        navbar.add_widget(logo)

        for name in ["Accueil", "Intervention", "Carte", "Equipement", "Demande"]:
            btn = Button(
                text=name if name != "Equipement" else f"[b]{name}[/b]",
                markup=(name == "Equipement"),
                background_color=(0, 0.4, 0.6, 1),
                color=(1, 1, 1, 1) if name != "Equipement" else (1, 0.6, 0, 1)
            )
            btn.bind(on_press=lambda inst, screen=name.lower(): setattr(self.manager, 'current', screen))
            navbar.add_widget(btn)

        logout = Button(
            size_hint=(None, 1),
            width=40,
            background_normal='logout.png',     # l'image que tu veux afficher
            background_down='logout.png',       # optionnel, même image pour le clic
            background_color=(1, 1, 1, 1),       # ne pas rendre l'image transparente
            border=(0, 0, 0, 0)                  # pour éviter l'étirement moche
        )
        logout.bind(on_press=lambda instance: setattr(self.manager, 'current', 'connexion'))
        navbar.add_widget(logout)
        root.add_widget(navbar)
        
        main = BoxLayout(orientation='horizontal', spacing=20)
        filters = AnchorLayout(anchor_y='center', size_hint=(0.25, 1))

        filters_container = BoxLayout(orientation='vertical', size_hint=(1, None), height=300, spacing=10)

        filter_card = BoxLayout(orientation='vertical', padding=[10, 10, 10, 10], spacing=10, size_hint=(1, None), height=150)
        with filter_card.canvas.before:
            Color(1, 1, 1, 1)
            self.filter_bg = RoundedRectangle(pos=filter_card.pos, size=filter_card.size, radius=[10])
        filter_card.bind(pos=self.update_rect_bg, size=self.update_rect_bg)

        label_filtrer = Label(text="Filtrer par", size_hint=(1, None), height=30, color=(0, 0, 0, 1))
        filter_card.add_widget(label_filtrer)

        btn_date = Button(text="Date", size_hint=(1, None), height=40)
        btn_date.bind(on_press=self.open_date_picker)
        filter_card.add_widget(btn_date)

        filter_card.add_widget(TextInput(hint_text="Lieu", size_hint=(1, None), height=40))
        filter_card.add_widget(Widget())
        filters_container.add_widget(filter_card)

        for text, color in [
            ("En stock", (0, 0.4, 0.6, 1)),
            ("Utilisé", (0.5, 0.8, 1, 1)),
            ("En rupture", (1.0, 0.45, 0.09, 1))
        ]:
            filters_container.add_widget(Button(text=text, background_color=color, background_normal='', color=(1, 1, 1, 1), size_hint=(1, None), height=40))

        filters.add_widget(filters_container)
        main.add_widget(filters)

        right_side = BoxLayout(orientation='vertical', spacing=10, size_hint=(0.75, 1))
        right_side.add_widget(Widget(size_hint_y=None, height=120))

        grid = GridLayout(cols=3, spacing=20, padding=10, size_hint=(1, 1))
        grid.bind(minimum_height=grid.setter('height'))
        self.equipement_grid = grid

        right_side.add_widget(grid)
        main.add_widget(right_side)

        root.add_widget(main)
        self.add_widget(root)

        self.load_equipements()

    def _update_bg(self, *args):
        self.bg_rect.pos = self.pos
        self.bg_rect.size = self.size

    def update_rect_bg(self, instance, value):
        self.filter_bg.pos = instance.pos
        self.filter_bg.size = instance.size

    def load_equipements(self):
        self.equipement_grid.clear_widgets()
        equipements = self.db.get_equipements()

        for idx, equipement in enumerate(equipements):
            if equipement['quantite_totale'] > 0:
                pourcentage = int((equipement['quantite_disponible'] / equipement['quantite_totale']) * 100)
            else:
                pourcentage = 0

            if idx < 3:
                couleur_dispo = (0, 0.4, 0.6, 1)
                couleur_manquant = (0.5, 0.8, 1, 1)
            else:
                couleur_dispo = (1.0, 0.45, 0.09, 1)
                couleur_manquant = (0, 0.4, 0.6, 1)

            widget = EquipementWidget(
                nom_equipement=equipement['nom'],
                statut=f"Total : {equipement['quantite_totale']} unités",
                pourcentage=pourcentage,
                couleur_dispo=couleur_dispo,
                couleur_manquant=couleur_manquant,
                couleur_statut=(1.0, 0.45, 0.09, 1),
                couleur_nom=(0.01, 0.19, 0.28, 1)  # 023047
            )
            widget.size_hint_y = None
            widget.height = 300

            if idx >= 3:
                btn = Button(
                    text="Recommandé",
                    size_hint=(1, None),
                    height=30,
                    background_color=(0, 0.3, 0.5, 1),
                    color=(1, 0.6, 0, 1)
                )
                box = BoxLayout(orientation='vertical', spacing=5, size_hint_y=None, height=335)
                box.add_widget(widget)
                box.add_widget(btn)
                self.equipement_grid.add_widget(box)
            else:
                self.equipement_grid.add_widget(widget)

    def open_date_picker(self, instance):
        content = BoxLayout(orientation='vertical', spacing=10, padding=10)
        year_spinner = Spinner(text="2025", values=[str(i) for i in range(1970, 2026)], size_hint_y=None, height=40)
        month_spinner = Spinner(text="Avril", values=["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
                                                    "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
                                size_hint_y=None, height=40)
        day_spinner = Spinner(text="20", values=[str(i) for i in range(1, 32)], size_hint_y=None, height=40)
        validate_btn = Button(text="OK", size_hint_y=None, height=40)

        content.add_widget(year_spinner)
        content.add_widget(month_spinner)
        content.add_widget(day_spinner)
        content.add_widget(validate_btn)

        popup = Popup(title="Choisir une date", content=content, size_hint=(None, None), size=(300, 300))

        def on_validate(instance):
            print("Date choisie:", day_spinner.text, month_spinner.text, year_spinner.text)
            popup.dismiss()

        validate_btn.bind(on_press=on_validate)
        popup.open()
