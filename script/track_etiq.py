from keyboard_alike import reader
import sqlite3
from datetime import datetime

def main():
    # Connexion à la base de données SQLite3
    connexion = sqlite3.connect('TRACK_EYE.db')
    curseur = connexion.cursor()

    
    # Initialisation du lecteur RFID
    reader_instance = reader.Reader(0xffff, 0x0035, 84, 16, should_reset=False)
    reader_instance.initialize()

    try:
        while True:
            # Lire en continu les entrées du lecteur RFID
            tag_id = reader_instance.read().strip()
            current_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            print("Tag RFID détecté à", current_time, ":", tag_id)
            
            # Insérer les données dans la base de données
            curseur.execute("INSERT INTO TRACK_ETIQ (DATE_TIME, NUM_ETIQ,ID_ANTENNE) VALUES (?, ?, ?)", (current_time, tag_id, 1,))
            connexion.commit()  # Valider la transaction

    except KeyboardInterrupt:
        print("\nArrêt de l'écoute du lecteur RFID.")
    
    finally:
        # Fermer la connexion à la base de données
        connexion.close()

if __name__ == "__main__":
    main()
