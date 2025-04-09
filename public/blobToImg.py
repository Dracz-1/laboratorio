import mysql.connector
import os
import base64
import time
from PIL import Image 
import requests

# Conectar ao banco de dados MySQL
def connect_to_db():
    try:
        # Alterar com os seus dados do banco de dados
        conn = mysql.connector.connect(
            host='localhost',       # Host do seu banco de dados
            user='root',     # Seu nome de usuário MySQL
            password='1234567890',   # Sua senha MySQL
            database='test_invent'  # Nome do seu banco de dados
        )
        return conn
    except mysql.connector.Error as err:
        print(f"Erro ao conectar ao MySQL: {err}")
        return None

# Função para salvar a imagem no diretório public/img
def save_image_from_blob(blob_data, file_name):
    img_path = os.path.join('public', 'img', file_name)
    with open(img_path, 'wb') as file:
        file.write(blob_data)
    return img_path

# Função para converter a imagem para Base64
def convert_to_base64(image_path):
    with open(image_path, 'rb') as image_file:
        return base64.b64encode(image_file.read()).decode('utf-8')

def process_images():
    # Conectar ao banco de dados
    conn = connect_to_db()
    if conn is None:
        return "Erro ao conectar ao banco de dados."

    cursor = conn.cursor()
    
    # Consultar os blobs de imagens do banco de dados
    cursor.execute("SELECT id, fotografia_blob FROM equipamentos WHERE fotografia_blob IS NOT NULL")
    rows = cursor.fetchall()
    
    # Processar cada imagem
    for row in rows:
        id, fotografia_blob = row
        
        # Gerar nome para a imagem
        file_name = f"equipamento_{id}.jpg"
        
        # Salvar a imagem no diretório public/img
        image_path = save_image_from_blob(fotografia_blob, file_name)

        # Converter imagem para base64
        base64_image = convert_to_base64(image_path)

        # Atualizar a URL da fotografia e o campo Base64 no banco de dados
        fotografia_url = f"/img/{file_name}"  # A URL para a imagem no Laravel
        cursor.execute("""
            UPDATE equipamentos
            SET fotografia_url = %s, fotografia_base64 = %s
            WHERE id = %s
        """, (fotografia_url, base64_image, id))

        conn.commit()

    cursor.close()
    conn.close()

    return "Imagens processadas e banco de dados atualizado."

if __name__ == "__main__":
    result = process_images()
    print(result)
