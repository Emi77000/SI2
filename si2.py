from PyQt5.QtCore import QUrl
from PyQt5.QtWidgets import QApplication
from PyQt5.QtWebEngineWidgets import QWebEngineView

app = QApplication([])

web = QWebEngineView()

url = QUrl("http://localhost:8888/SI2/login.php")
web.load(url)

web.show()

app.exec_()
