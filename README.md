# Sistema de Agendamentos - Appointment Cloud

![Screenshot da Aplicação](Captura%20de%20tela%20de%202025-04-11%2014-57-42.png)

Sistema CRUD completo para gerenciamento de agendamentos, desenvolvido com PHP e MySQL em ambiente virtualizado.

## Pré-requisitos

- Multipass instalado
- 3 máquinas virtuais configuradas:
  - `web` (Apache/PHP)
  - `db` (MySQL)
  - `dns` (Bind9)
- Git instalado

## Instalação

### 1. Clone o repositório na máquina web:
multipass shell web
git clone https://github.com/MarcosV1996/appointament-cloud.git
cd appointament-cloud

## 2. Configure o banco de dados na máquina db:
multipass shell db
mysql -u root -p

CREATE DATABASE appointment_system;
CREATE USER 'app_user_web'@'10.13.246.200' IDENTIFIED BY 'App@1234';
GRANT ALL PRIVILEGES ON appointment_system.* TO 'app_user_web'@'10.13.246.200';
FLUSH PRIVILEGES;

### Execute no MySQL:

USE appointment_system;

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    appointment_date DATETIME NOT NULL,
    service_type ENUM('social','psychological','legal','medical') NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    status ENUM('scheduled','completed','cancelled') DEFAULT 'scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

## 3. Configure o Apache:
sudo nano /etc/apache2/sites-available/appointments.conf

em seguida adicione 

<VirtualHost *:80>
    ServerName appointments.web
    DocumentRoot /home/ubuntu/appointament-cloud
    <Directory /home/ubuntu/appointament-cloud>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

## Para ativar o site 
sudo a2ensite appointments.conf
sudo systemctl restart apache2

## Configuração DNS
Na máquina dns:

sudo nano /etc/bind/named.conf.local

## adicione

zone "appointments.web" {
    type master;
    file "/etc/bind/db.appointments.web";
};

## Crie o arquivo de zona:


sudo cp /etc/bind/db.local /etc/bind/db.appointments.web
sudo nano /etc/bind/db.appointments.web

## caso ocorra erro ao acessar o site 

Erro 500 ao acessar, vc pode conferir os logs últimas linhas:

sudo tail -f /var/log/apache2/error.log

## Problemas de conexão com MySQL
mysql -u app_user_web -pApp@1234 -h 10.13.246.141 appointment_system -e "SHOW TABLES;"

## Permissões incorretas
sudo chown -R www-data:www-data /home/ubuntu/appointament-cloud
sudo chmod -R 755 /home/ubuntu/appointament-cloud