from kivy.uix.screenmanager import Screen
from kivy.uix.boxlayout import BoxLayout
from kivy.uix.label import Label
from kivy.uix.button import Button
from kivy.uix.scrollview import ScrollView
from kivy.graphics import Color, RoundedRectangle

from database import Database

class InterventionDetailScreen(Screen):
    def __init__(self, **kwargs):
        super().__init__(**kwargs)
        self.db = Database()

        # Layout principal
        self.root_layout = BoxLayout(orientation='vertical', padding=20, spacing=20)
        self.add_widget(self.root_layout)

    def load_intervention(self, intervention_id):
        # 🧹 Nettoyer l'affichage précédent
        self.root_layout.clear_widgets()

        # 🔎 Requête pour récupérer l'intervention
        query = "SELECT * FROM interventions WHERE id = %s"
        self.db.cursor.execute(query, (intervention_id,))
        intervention = self.db.cursor.fetchone()

        if not intervention:
            self.root_layout.add_widget(Label(text="Intervention non trouvée.", font_size=24))
            return

        # ➡️ Titre principal
        title = Label(
            text=f"[b]{intervention['intitule']}[/b]",
            markup=True,
            font_size=28,
            size_hint=(1, None),
            height=50
        )
        self.root_layout.add_widget(title)

        # ➡️ ScrollView pour détails
        scroll = ScrollView()
        detail_layout = BoxLayout(orientation='vertical', size_hint_y=None, spacing=10, padding=10)
        detail_layout.bind(minimum_height=detail_layout.setter('height'))

        def add_info(label, value):
            line = BoxLayout(orientation='horizontal', size_hint=(1, None), height=30)
            line.add_widget(Label(text=f"[b]{label}[/b]:", markup=True, size_hint=(0.4, 1), color=(0,0,0,1)))
            line.add_widget(Label(text=str(value), size_hint=(0.6, 1), color=(0,0,0,1)))
            detail_layout.add_widget(line)

        # ➡️ Ajout des informations
        add_info("ID Intervention", intervention['id'])
        add_info("Référence Demande", intervention['reference_demande'])
        add_info("Date Intervention", intervention['date_intervention'])
        add_info("Lieu", intervention['lieu'])
        add_info("Statut", intervention['statut'])
        add_info("Importance", intervention['importance'])
        add_info("Coût estimé", intervention['cout'])
        add_info("Membre équipe", intervention['membre'])
        add_info("Équipement mobilisé", intervention['equipement'])
        add_info("Description", intervention['description'])

        scroll.add_widget(detail_layout)
        self.root_layout.add_widget(scroll)

        # ➡️ Boutons d'action
        button_layout = BoxLayout(size_hint=(1, None), height=50, spacing=20)

        retour_btn = Button(text="Retour", background_color=(0.2, 0.5, 0.7, 1))
        retour_btn.bind(on_press=lambda instance: setattr(self.manager, 'current', 'intervention'))

        creer_btn = Button(text="Créer Intervention", background_color=(0.2, 0.5, 0.7, 1))
        creer_btn.bind(on_press=lambda instance: setattr(self.manager, 'current', 'form_intervention'))

        button_layout.add_widget(retour_btn)
        button_layout.add_widget(creer_btn)

        self.root_layout.add_widget(button_layout)
