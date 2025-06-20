import time
import mysql.connector
from mysql.connector import pooling
from nameko.extensions import DependencyProvider

class DatabaseWrapper:
    connection = None

    def __init__(self, connection):
        self.connection = connection

    def get_all_members(self, search=None):
        cursor = self.connection.cursor(dictionary=True)
        result = []

        sql = "SELECT * FROM members WHERE 1=1"
        params = []

        if search:
            sql += " AND LOWER(nama) LIKE %s"
            params.append(f"%{search.lower()}%")

        cursor.execute(sql, params)

        for row in cursor.fetchall():
            result.append({
                'id': row['id'],
                'email': row['email'],
                'nama': row['nama'],
                'tanggal_lahir': row['tanggal_lahir'],
                'no_hp': row['no_hp']
            })

        cursor.close()
        return result

    def get_member_by_id(self, id):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT id, email, nama, tanggal_lahir, no_hp, token, token_expires_at FROM members WHERE id = %s"
        cursor.execute(sql, (id,))
        result = cursor.fetchone()
        cursor.close()
        return result

    def get_member_by_email(self, email):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT * FROM members WHERE email = %s"
        cursor.execute(sql, (email,))
        result = cursor.fetchone()
        cursor.close()
        return result

    def register_member(self, email, nama, tanggal_lahir, no_hp, password_hashed):
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("INSERT INTO members (email, nama, tanggal_lahir, no_hp, password) VALUES (%s, %s, %s, %s, %s)", (email, nama, tanggal_lahir, no_hp, password_hashed))
        self.connection.commit()
        member_id = cursor.lastrowid
        cursor.close()
        return self.get_member_by_id(member_id)

    def update_member(self, member_id, update_data):
        if not update_data:
            raise ValueError("No update data provided")
        cursor = self.connection.cursor(dictionary=True)
        fields = []
        values = []
        for key, value in update_data.items():
            if key != 'member_id':  # Jangan update kolom member_id
                fields.append(f"{key} = %s")
                values.append(value)
        values.append(member_id)  # gunakan member_id untuk WHERE id = %s
        sql = f"UPDATE members SET {', '.join(fields)} WHERE id = %s"
        cursor.execute(sql, tuple(values))
        self.connection.commit()
        cursor.execute("SELECT id, email, nama, tanggal_lahir, no_hp FROM members WHERE id = %s", (member_id,))
        updated_member = cursor.fetchone()
        cursor.close()
        return updated_member

    def save_token(self, member_id: int, token: str, token_expires_at) -> bool:
        try:
            cursor = self.connection.cursor()
            sql = "UPDATE members SET token = %s, token_expires_at = %s WHERE id = %s"
            cursor.execute(sql, (token, token_expires_at, member_id))
            self.connection.commit()
            cursor.close()
            return True
        except mysql.connector.Error as e:
            print(f"Error saving token: {e}")
            return False

    def delete_token(self, member_id: int) -> bool:
        try:
            cursor = self.connection.cursor()
            sql = "UPDATE members SET token = NULL, token_expires_at = NULL WHERE id = %s"
            cursor.execute(sql, (member_id,))
            self.connection.commit()
            cursor.close()
            return True
        except mysql.connector.Error as e:
            print(f"Error deleting token: {e}")
            return False

    def get_member_by_token(self, token):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT * FROM members WHERE token = %s"
        cursor.execute(sql, (token,))
        result = cursor.fetchone()
        cursor.close()
        return result

    def delete_member_by_id(self, member_id):
        try:
            cursor = self.connection.cursor()
            sql = "DELETE FROM members WHERE id = %s"
            cursor.execute(sql, (member_id,))
            self.connection.commit()
            cursor.close()
            return True
        except mysql.connector.Error as e:
            print(f"Error deleting member: {e}")
            return False

    def __del__(self):
        self.connection.close()


class Database(DependencyProvider):
    connection_pool = None

    def __init__(self):
        # Try to connect multiple times with delays
        retries = 5
        for attempt in range(retries):
            try:
                self.connection_pool = pooling.MySQLConnectionPool(
                    pool_name="database_pool",
                    pool_size=10,
                    pool_reset_session=True,
                    host='member-mysql',
                    database='soa_project_2025',
                    user='root',
                    password=''
                )
                print("MySQL connection pool created successfully")
                break
            except mysql.connector.Error as e:
                print(f"Attempt {attempt + 1} - MySQL connection failed: {e}")
                time.sleep(3)  # wait 3 seconds before retry
        else:
            # After retries exhausted
            print("Failed to connect to MySQL after several attempts.")
            self.connection_pool = None

    def get_dependency(self, worker_ctx):
        return DatabaseWrapper(self.connection_pool.get_connection())
