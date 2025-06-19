# Gunakan image Python resmi
FROM python:3.11-slim

# Set working directory
WORKDIR /app

# Salin semua file ke container
COPY . /app

# Install dependencies
RUN pip install --upgrade pip
RUN pip install -r requirements.txt

EXPOSE 8002

# Jalankan Nameko service
CMD ["nameko", "run", "auth_service", "--config", "nameko.yml"]