from kivy.uix.screenmanager import Screen
from kivy.uix.boxlayout import BoxLayout
from kivy.uix.label import Label
from kivy.uix.button import Button
from kivy.uix.textinput import TextInput
from kivy.uix.gridlayout import GridLayout
from kivy.uix.scrollview import ScrollView
from kivy.uix.image import Image
from kivy.uix.widget import Widget
from kivy.graphics import Color, RoundedRectangle, Ellipse
from kivy.core.window import Window

from database import Database

class InterventionScreen(Screen):
    def __init__(self, **kwargs):
        super().__init__(**kwargs)

        self.db = Database()
        self.root_layout = BoxLayout(orientation='vertical', spacing=10, padding=20)

        with self.root_layout.canvas.before:
            Color(222/255, 240/255, 248/255, 1)
            self.bg_rect = RoundedRectangle(pos=self.root_layout.pos, size=self.root_layout.size)
        self.root_layout.bind(pos=self.update_bg, size=self.update_bg)
        self.add_widget(self.root_layout)

        self.create_navbar()
        self.root_layout.add_widget(Widget(size_hint_y=None, height=20))
        self.create_top_row()
        self.create_headers()
        self.create_scrollview()
        self.load_interventions()
        self.create_charts()

    def update_bg(self, instance, value):
        self.bg_rect.pos = instance.pos
        self.bg_rect.size = instance.size

    def create_navbar(self):
        # Augmentation de la taille de la barre de navigation
        nav = BoxLayout(size_hint=(1, 0.15), spacing=5)  # Réduit l'espacement pour mieux s'adapter aux textes plus grands
        
        logo = Label(text="Airblio", font_size=24, bold=True, color=(0.13, 0.62, 0.74, 1), size_hint=(None, 1), width=100)
        nav.add_widget(logo)

        buttons = [
            ("Accueil", "accueil"),
            ("Intervention", "intervention"),
            ("Carte", "carte"),
            ("Equipement", "equipement"),
            ("Demande", "demande")
        ]

        for name, screen in buttons:
            btn = Button(
                text=name if name != "Intervention" else f"[b]{name}[/b]",
                markup=True,
                background_color=(0, 0.4, 0.6, 1) if name != "Intervention" else (0.13, 0.45, 0.55, 1),
                color=(1, 1, 1, 1) if name != "Intervention" else (1, 0.6, 0, 1),
                font_size=22  # Augmentation significative de la taille de police
            )
            btn.bind(on_press=lambda inst, s=screen: setattr(self.manager, 'current', s))
            nav.add_widget(btn)

        logout = Button(
            size_hint=(None, 1),
            width=80,  # Augmentation supplémentaire de la largeur
            background_normal='logout.png',
            background_down='logout.png',
            background_color=(1, 1, 1, 1),
            border=(0, 0, 0, 0)
        )
        logout.bind(on_press=lambda instance: setattr(self.manager, 'current', 'connexion'))
        nav.add_widget(logout)
        self.root_layout.add_widget(nav)


    def create_top_row(self):
        top_row = BoxLayout(size_hint=(1, None), height=100, spacing=10)

        # Barre de recherche + bouton
        left_box = BoxLayout(orientation='horizontal', spacing=10, size_hint=(0.3, 1))

        create_button = Button(
            text="Créer une Intervention",
            size_hint=(None, None),
            width=230,
            height=60,
            background_normal='',            
            background_color=(33/255, 158/255, 188/255, 1),
            color=(1, 1, 1, 1),
            font_size=18
        )
        create_button.bind(on_press=self.go_to_form)

        search_container = BoxLayout(size_hint=(None, None), width=630, height=60)
        with search_container.canvas.before:
            Color(1, 1, 1, 1)  # Fond blanc
            self.search_bg = RoundedRectangle(pos=search_container.pos, size=search_container.size, radius=[10])
        search_container.bind(pos=self.update_search_bg, size=self.update_search_bg)
        
        self.search_input = TextInput(
            hint_text="Rechercher une intervention",
            background_color=(0, 0, 0, 0),
            foreground_color=(0, 0, 0, 1),
            cursor_color=(0, 0, 0, 1),
            size_hint=(1, 1),
            font_size=20,
            multiline=False,
            padding=(10, 10)
        )
        self.search_input.bind(text=self.on_search_text)
        search_container.add_widget(self.search_input)

        left_box.add_widget(create_button)
        left_box.add_widget(search_container)

        # Spacer pour pousser les cartes à droite
        spacer = Widget(size_hint=(0.05, 1))
        
        # Cartes collées à droite
        cards_layout = BoxLayout(orientation='horizontal', spacing=50, size_hint=(0.4, 1))
        cards = [
            ("Interventions terminées", "150", (0, 0.6, 0, 1)),
            ("Interventions en cours", "25", (1, 0.6, 0, 1)),
            ("Interventions à venir", "15", (1, 0.75, 0.1, 1)),
            ("Interventions en retard", "5", (1, 0, 0, 1))
        ]

        for title, count, color in cards:
            card = BoxLayout(orientation='vertical', padding=10, size_hint=(1, 1))
            card.add_widget(Label(text=title, color=(0, 0, 0, 1), font_size=18))
            card.add_widget(Label(text=count, color=color, font_size=34))
            with card.canvas.before:
                Color(180/255, 225/255, 240/255, 1)
                card.rect = RoundedRectangle(pos=card.pos, size=card.size, radius=[10])
            card.bind(pos=self.update_card_bg, size=self.update_card_bg)
            cards_layout.add_widget(card)

        top_row.add_widget(left_box)
        top_row.add_widget(spacer)
        top_row.add_widget(cards_layout)
        self.root_layout.add_widget(top_row)

    def update_search_bg(self, instance, value):
        self.search_bg.pos = instance.pos
        self.search_bg.size = instance.size

    def update_card_bg(self, instance, value):
        instance.rect.pos = instance.pos
        instance.rect.size = instance.size

    def create_headers(self):
        headers = GridLayout(cols=7, size_hint_y=None, height=40, spacing=10)
        titles = ["N° intervention", "Réf Demande", "Intitulé", "Date", "Lieu", "Statut", "Importance"]
        for title in titles:
            lbl = Label(text='[b]'+title+'[/b]', markup=True, color=(0, 0, 0, 1))
            headers.add_widget(lbl)
        self.root_layout.add_widget(headers)

    def create_scrollview(self):
        self.scroll = ScrollView(size_hint=(1, 1))
        self.intervention_list = GridLayout(cols=1, spacing=10, size_hint_y=None, padding=(0, 10))
        self.intervention_list.bind(minimum_height=self.intervention_list.setter('height'))
        self.scroll.add_widget(self.intervention_list)
        self.root_layout.add_widget(self.scroll)

    def load_interventions(self):
        self.intervention_list.clear_widgets()
        all_interventions = self.db.get_interventions()
        search_text = self.search_input.text.lower().strip()
        
        # Filtrer les interventions selon le texte de recherche
        filtered = [i for i in all_interventions if search_text in str(i.get("intitule", "")).lower() or 
                                                    search_text in str(i.get("id", "")).lower() or
                                                    search_text in str(i.get("lieu", "")).lower() or
                                                    search_text in str(i.get("reference_demande", "")).lower()]

        for intervention in reversed(filtered):
            row = BoxLayout(size_hint_y=None, height=40, spacing=10)
            
            # Ajouter effet de survol
            def on_mouse_pos(_, pos, row=row):
                if not row.get_root_window():
                    return  # évite erreur si widget non monté
                inside = row.collide_point(*row.to_widget(*pos))
                with row.canvas.before:
                    row.canvas.before.clear()
                    if inside:
                        Color(0.56, 0.79, 0.9, 1)  # couleur 8ECAE6
                    else:
                        Color(1, 1, 1, 1)
                    row.bg_rect = RoundedRectangle(pos=row.pos, size=row.size, radius=[8])
                
                row.bind(pos=self.update_row_rect, size=self.update_row_rect)
            
            Window.bind(mouse_pos=on_mouse_pos)

            # Créer un grid layout pour les 6 premières colonnes
            data_layout = GridLayout(cols=6, size_hint_x=0.9)
            for key in ["id", "reference_demande", "intitule", "date_intervention", "lieu", "statut"]:
                val = str(intervention.get(key, ""))
                if key == "intitule" and len(val) > 44:
                    val = val[:37] + "..."
                if key == "lieu" and ',' in val:
                    val = val.split(',', 1)[1].strip()
                data_layout.add_widget(Label(text=val, color=(0, 0.2, 0.3, 1)))
            row.add_widget(data_layout)

            # Déterminer la couleur du point selon l'importance
            color = (0, 0.6, 0, 1)  # Faible (vert)
            if intervention.get("importance") == "Moyenne":
                color = (1, 0.6, 0, 1)  # Moyenne (orange)
            elif intervention.get("importance") == "Élevée":
                color = (1, 0, 0, 1)  # Élevée (rouge)

            # Créer un conteneur pour le point de couleur (dernière colonne)
            dot_container = BoxLayout(size_hint_x=0.1, padding=(0, 2, 0, 0))
            
            # Créer un layout vertical pour pouvoir ajuster la position verticalement
            dot_vertical_layout = BoxLayout(orientation='vertical')
            
            # Ajouter un petit widget d'espacement en haut pour monter les pastilles
            dot_vertical_layout.add_widget(Widget(size_hint_y=0.2))
            
            # Layout horizontal pour centrer la pastille
            dot_horizontal_layout = BoxLayout(size_hint_y=0.6)
            dot_horizontal_layout.add_widget(Widget())  # spacer à gauche
            
            # Pastille elle-même
            dot_layout = BoxLayout(size_hint=(None, None), size=(20, 20))
            
            # Dessiner le cercle
            with dot_layout.canvas:
                Color(*color)
                dot_layout.ellipse = Ellipse(pos=dot_layout.pos, size=dot_layout.size)
            
            # Mise à jour de la position
            def update_ellipse(instance, value):
                instance.ellipse.pos = instance.pos
                instance.ellipse.size = instance.size
            
            dot_layout.bind(pos=update_ellipse, size=update_ellipse)
            
            dot_horizontal_layout.add_widget(dot_layout)
            dot_horizontal_layout.add_widget(Widget())  # spacer à droite
            
            dot_vertical_layout.add_widget(dot_horizontal_layout)
            dot_vertical_layout.add_widget(Widget(size_hint_y=0.2))  # 20% d'espace en bas
            
            dot_container.add_widget(dot_vertical_layout)
            
            row.add_widget(dot_container)
            row.bind(on_touch_down=self.make_row_touch_handler(intervention))
            self.intervention_list.add_widget(row)

    def update_row_rect(self, instance, value):
        instance.bg_rect.pos = instance.pos
        instance.bg_rect.size = instance.size

    def on_search_text(self, instance, value):
        self.load_interventions()

    def make_row_touch_handler(self, intervention):
        def handler(instance, touch):
            if instance.collide_point(*touch.pos):
                self.show_details(intervention["id"])
                return True
            return False
        return handler

    def create_charts(self):
        chart_row = BoxLayout(size_hint=(1, None), height=250, spacing=10)
        chart_row.add_widget(Image(source="bar_chart.png"))
        chart_row.add_widget(Image(source="intervention_list.png"))
        chart_row.add_widget(Image(source="pie_chart.png"))
        self.root_layout.add_widget(chart_row)

    def go_to_form(self, instance):
        form_screen = self.manager.get_screen('form_intervention')
        form_screen.reset_form()  # vide les anciens champs
        self.manager.current = 'form_intervention'

    def show_details(self, intervention_id):
        detail_screen = self.manager.get_screen('intervention_detail')
        detail_screen.load_intervention(intervention_id)
        self.manager.current = 'intervention_detail'