# WebLab | Учебная платформа для студентов

<p align="left">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

**WebLab** — это минималистичная LMS (Learning Management System), разработанная специально для проведения занятий по веб-разработке. Платформа автоматизирует процесс выдачи теории, заданий и сдачи лабораторных работ через GitHub.

## Основной функционал

- **Студенты и группы:** Регистрация студентов с привязкой к учебным группам.
- **Учебные материалы:** Публикация лекций, мануалов по настройке софта и домашних заданий.
- **Проверка кода:** Студенты сдают выполненные задания в виде ссылок на свои Git-репозитории.
- **Админ-панель:** Удобная панель преподавателя (на базе Filament PHP) для управления группами, контентом и проверки ДЗ.

---

## Технический стек

Проект полностью контейнеризирован и готов к локальной разработке.

- **Backend:** Laravel, PHP 8.3
- **Frontend:** Laravel Blade, TailwindCSS, Vite (HMR)
- **Database:** PostgreSQL 16
- **Cache & Sessions:** Redis 7
- **Web Server:** Nginx
- **Инфраструктура:** Docker & Docker Compose

---

## Локальный запуск (Разработка)

Для запуска проекта на вашем компьютере должны быть установлены [Git](https://git-scm.com/) и [Docker Desktop](https://www.docker.com/products/docker-desktop/) (или Docker Engine).

### 1. Клонирование и настройка окружения
```bash

# Склонируйте репозиторий
git clone https://github.com/ВАШ_НИК/weblab.git
cd weblab
```

```bash

# Создайте файл конфигурации
cp .env.example .env
```
#### Убедитесь, что в **.env** файле указаны правильные докер-хосты (DB_HOST=postgres, REDIS_HOST=redis) и включен режим дебага (APP_DEBUG=true).

### 2. Запуск контейнеров

#### Поднимите инфраструктуру проекта (БД, Redis, Nginx, PHP и NodeJS):

```bash

docker compose up -d --build
```

### 3. Установка зависимостей и базы данных
#### Зайдите внутрь контейнера PHP:

```bash

docker exec -it php bash
```

#### Выполните базовые команды Laravel для инициализации:

```bash

composer install
php artisan key:generate
php artisan migrate --seed
```
#### (Для выхода из контейнера введите exit)

### 4. Готово! 
#### Проект успешно запущен и доступен по адресу: http://localhost

