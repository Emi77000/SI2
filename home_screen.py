from kivy.uix.screenmanager import Screen
from kivy.uix.boxlayout import BoxLayout
from kivy.uix.label import Label
from kivy.uix.button import Button
from kivy.uix.gridlayout import GridLayout
from kivy.uix.widget import Widget
from kivy.graphics import Color, RoundedRectangle, Ellipse
from carte_widget import CarteWidget
from equipement_widget import EquipementWidget
from database import Database

class AccueilScreen(Screen):
    def __init__(self, **kwargs):
        super().__init__(**kwargs)
        self.db = Database()

        root = BoxLayout(orientation='vertical', spacing=5, padding=10)
        with root.canvas.before:
            Color(0.90, 0.95, 0.97, 1)
            self.bg_rect = RoundedRectangle(pos=root.pos, size=root.size)
        root.bind(pos=self.update_bg, size=self.update_bg)

        # NAVBAR
        navbar = BoxLayout(size_hint=(1, 0.1), spacing=10)
        logo = Label(text="Airblio", font_size=24, bold=True, color=(1, 1, 1, 1), size_hint=(None, 1), width=100)
        navbar.add_widget(logo)

        buttons = [
            ("Accueil", "accueil"),
            ("Intervention", "intervention"),
            ("Carte", "carte"),
            ("Equipement", "equipement"),
            ("Demande", "demande")
        ]

        for name, screen in buttons:
            btn = Button(
                text=name if name != "Accueil" else f"[b]{name}[/b]",
                markup=(name == "Accueil"),
                background_color=(0, 0.4, 0.6, 1),
                size_hint=(1, 1),
                color=(1, 1, 1, 1) if name != "Accueil" else (1, 0.6, 0, 1)
            )
            btn.bind(on_press=lambda inst, s=screen: setattr(self.manager, 'current', s))
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

        # ALERT
        alert_box = BoxLayout(size_hint=(1, None), height=40, padding=10)
        with alert_box.canvas.before:
            Color(1.0, 0.60, 0.0, 1)
            alert_box.bg = RoundedRectangle(pos=alert_box.pos, size=alert_box.size, radius=[10])
        alert_box.bind(pos=self.update_alert_bg, size=self.update_alert_bg)
        alert_box.add_widget(Label(
            text="\u26a0 Alerte ! Demande d’intervention suite à une tempête N°Client : 5204",
            color=(1, 1, 1, 1), font_size=16, halign='center', valign='middle'
        ))
        root.add_widget(alert_box)

        # CONTENT
        content = GridLayout(cols=2, spacing=10, padding=10, size_hint=(1, 0.8))

        content.add_widget(self.make_projets_section())
        content.add_widget(self.make_equipement_section())
        content.add_widget(self.make_interventions_section())
        content.add_widget(self.make_carte_section())

        root.add_widget(content)
        self.add_widget(root)

    def update_bg(self, instance, value):
        self.bg_rect.pos = instance.pos
        self.bg_rect.size = instance.size

    def update_alert_bg(self, instance, value):
        if hasattr(instance, 'bg'):
            instance.bg.pos = instance.pos
            instance.bg.size = instance.size

    def update_section_bg(self, instance, value):
        if hasattr(instance, 'bg'):
            instance.bg.pos = instance.pos
            instance.bg.size = instance.size

    def make_section_box(self):
        box = BoxLayout(orientation='vertical', padding=10, spacing=10)
        with box.canvas.before:
            Color(0.75, 0.88, 0.96, 1)
            box.bg = RoundedRectangle(pos=box.pos, size=box.size, radius=[15])
        box.bind(pos=self.update_section_bg, size=self.update_section_bg)
        box.size_hint = (1, 1)
        return box

    def make_projets_section(self):
        box = self.make_section_box()
        inner = BoxLayout(orientation='vertical', spacing=10)

        inner.add_widget(Label(text="Projets", font_size=20, bold=True,
                               color=(0.00, 0.23, 0.36, 1), size_hint_y=None, height=30))

        for p in self.db.get_projets():
            ligne = BoxLayout(orientation='horizontal', padding=10, spacing=10,
                              size_hint_y=None, height=50)
            with ligne.canvas.before:
                Color(1, 1, 1, 1)
                ligne.bg = RoundedRectangle(pos=ligne.pos, size=ligne.size, radius=[10])
            ligne.bind(pos=self.update_section_bg, size=self.update_section_bg)
            ligne.add_widget(Label(text=p.get("nom_projet", ""), color=(0.00, 0.23, 0.36, 1)))
            ligne.add_widget(Label(text=p.get("membres", "") or "Aucun membre", color=(0.00, 0.23, 0.36, 1)))
            ligne.add_widget(Label(text=p.get("statut", ""), color=(0.00, 0.23, 0.36, 1)))
            inner.add_widget(ligne)

        box.add_widget(inner)
        return box

    def make_equipement_section(self):
        box = self.make_section_box()
        inner = BoxLayout(orientation='vertical', spacing=10)

        inner.add_widget(Label(text="Équipements", font_size=20, bold=True,
                               color=(0.00, 0.23, 0.36, 1), size_hint_y=None, height=30))

        grid = GridLayout(cols=2, spacing=10, size_hint=(1, 1), padding=10)

        equipements = [
            {'nom': 'Caisson Hyperbare', 'quantite_disponible': 30, 'quantite_totale': 50},
            {'nom': 'Sonar de Plongée', 'quantite_disponible': 20, 'quantite_totale': 40},
            {'nom': 'Combinaison de Plongée Étanche', 'quantite_disponible': 60, 'quantite_totale': 80},
            {'nom': 'Propulseur Sous–Marin', 'quantite_disponible': 5, 'quantite_totale': 10}
        ]

        for e in equipements:
            pourcentage = int((e['quantite_disponible'] / e['quantite_totale']) * 100) if e['quantite_totale'] else 0
            grid.add_widget(EquipementWidget(
                nom_equipement=e['nom'],
                statut=f"{e['quantite_disponible']}/{e['quantite_totale']}",
                pourcentage=pourcentage,
                couleur_dispo=(0, 0.4, 0.6, 1),         # bleu foncé
                couleur_manquant=(0.5, 0.8, 1, 1)       # bleu clair
            ))

        inner.add_widget(grid)
        box.add_widget(inner)
        return box

    def make_interventions_section(self):
        box = self.make_section_box()
        inner = BoxLayout(orientation='vertical', spacing=10)

        inner.add_widget(Label(text="Interventions", font_size=20, bold=True,
                               color=(0.00, 0.23, 0.36, 1), size_hint_y=None, height=30))

        for i in self.db.get_interventions():
            ligne = BoxLayout(orientation='horizontal', padding=10, spacing=10,
                              size_hint_y=None, height=50)
            with ligne.canvas.before:
                Color(1, 1, 1, 1)
                ligne.bg = RoundedRectangle(pos=ligne.pos, size=ligne.size, radius=[10])
            ligne.bind(pos=self.update_section_bg, size=self.update_section_bg)
            ligne.add_widget(Label(text=i.get("reference_demande") or "", color=(0.00, 0.23, 0.36, 1)))
            ligne.add_widget(Label(text=i.get("intitule", ""), color=(0.00, 0.23, 0.36, 1)))
            date_str = i.get("date_intervention", "")
            if date_str:
                date_str = date_str.strftime('%d/%m')
            ligne.add_widget(Label(text=str(date_str or ""), color=(0.00, 0.23, 0.36, 1)))

            dot = Widget(size_hint=(None, None), size=(12, 12))
            with dot.canvas:
                Color(*{
                    'haute': (1, 0, 0, 1),
                    'moyenne': (1, 0.6, 0, 1),
                    'basse': (0.3, 0.7, 0.2, 1)
                }.get(i.get("importance", "").lower(), (0.6, 0.6, 0.6, 1)))
                Ellipse(pos=(0, 0), size=(12, 12))
            ligne.add_widget(dot)
            inner.add_widget(ligne)

        box.add_widget(inner)
        return box

    def make_carte_section(self):
        box = self.make_section_box()
        inner = BoxLayout(orientation='vertical', spacing=10)

        inner.add_widget(Label(text="Carte", font_size=20, bold=True,
                               color=(0.00, 0.23, 0.36, 1), size_hint_y=None, height=30))
        inner.add_widget(CarteWidget(size_hint=(1, 1)))

        box.add_widget(inner)
        return box