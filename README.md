# Project Name: Project Management Platform

This project is a comprehensive platform designed to streamline project management, task tracking, and team collaboration. Built with Laravel, it offers robust features for managing projects from inception to completion, enabling efficient communication and workflow optimization for teams of all sizes.

---

## Table of Contents

* [About The Project](#about-the-project)
* [Features](#features)
* [Getting Started](#getting-started)
    * [Prerequisites](#prerequisites)
    * [Installation](#installation)
    * [Initial Setup](#initial-setup)
    * [Running the Application](#running-the-application)
    * [Running the Redis Queue](#running-the-redis-queue)
* [Development Tools](#development-tools)
    * [Database Access](#database-access)
    * [Email Testing with Mailpit](#email-testing-with-mailpit)
    * [Queue Monitoring with Horizon](#queue-monitoring-with-horizon)
    * [Debugging with Xdebug](#debugging-with-xdebug)
* [Basic Usage](#basic-usage)
    * [Running Artisan Commands](#running-artisan-commands)
    * [Running Tests](#running-tests)
    * [NPM Commands](#npm-commands)
* [Troubleshooting](#troubleshooting)
* [Contributing](#contributing)
* [License](#license)

---

## About The Project

The Project Management Platform is developed using the Laravel framework, providing a scalable and maintainable solution for managing projects. It aims to offer a user-friendly interface for creating, assigning, tracking tasks, and monitoring project progress. Key functionalities include user authentication, role-based access control, task assignment, status updates, and notification systems, ensuring that project stakeholders are always informed.

---

## Features

* **User Management:** Secure user registration, login, and role-based access control.
* **Project Creation & Management:** Create, update, and categorize projects with detailed descriptions.
* **Task Management:** Assign tasks to team members, set deadlines, and track progress.
* **Status Updates:** Clearly defined task and project statuses for transparent progress tracking.
* **Notifications:** Email notifications for important project updates and task assignments.
* **Team Collaboration:** Facilitates collaboration among team members on shared projects.

---

## Getting Started

These instructions will get a copy of the project up and running on your local machine for development and testing purposes using Laravel Sail, a light-weight command-line interface for interacting with Laravel's default Docker development environment.

### Prerequisites

Ensure you have the following installed on your system:

* **Docker Desktop**: [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
    * Make sure Docker is running before proceeding.
* **Git**: [https://git-scm.com/downloads](https://git-scm.com/downloads)
* **PHP** (8.2 or higher recommended)
* **Composer**
* **Node.js & NPM** (for frontend asset compilation, if applicable)

### Installation

1.  **Clone the Repository**:

    ```bash
    git clone [https://github.com/shaxzodbe/project-management-platform.git](https://github.com/shaxzodbe/project-management-platform.git)
    cd project-management-platform
    ```

### Initial Setup

1. **Copy Environment File**:
    Laravel uses an `.env` file for environment-specific configurations.

    ```bash
    cp .env.example .env
    ```
2. **Install Composer Dependencies**:
    This command runs `composer install` inside the PHP container. The `--ignore-platform-reqs` flag can be useful in some Docker environments.

    ```bash
    composer install --ignore-platform-reqs
    ```
3. **Running the Application**:
    To serve your Laravel application from Docker.

    ```bash
    ./vendor/bin/sail up -d
    ```

4. **Generate Application Key**:
    This command generates a unique key for your application's security.

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

5. **Database Migrations and Seeding**:
    Run the database migrations to create the necessary tables, and then seed the database with initial data (if seeders are configured).

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```
   
6. **Running the Queue**:

    To serve your Laravel queue from Docker (useful for background jobs like sending emails:

    ```bash
    ./vendor/bin/sail artisan queue:work
    ```
   
    You can see sended mails in * **Mailpit**: [http://localhost:8025](http://localhost:8025)               

7. **Import Postman Collection**:

    Collection located in 
    ```bash
    project-management-platform/storage/Laravel API Collection.postman_collection.json
    ```
## Roles and Permissions

This project implements a comprehensive roles and permissions system utilizing the `spatie/laravel-permission` package to manage user access effectively.

### Defined Permissions

The application defines a granular set of permissions categorized by the resources they control:

* **Project Permissions:**
    * `create-project`
    * `view-any-project`
    * `view-project`
    * `update-project`
    * `delete-project`

* **Task Permissions:**
    * `create-task`
    * `view-any-task`
    * `view-task`
    * `update-task`
    * `delete-task`
    * `assign-task`
    * `update-task-status`

* **User Permissions:**
    * `view-any-user`
    * `view-user`
    * `create-user`
    * `update-user`
    * `delete-user`
    * `manage-users`

### System Roles

Four distinct roles are established, each assigned a specific set of permissions:

* **`admin`**: This role possesses **all available permissions**, granting full control over the system.

* **`project_manager`**: Equipped with comprehensive permissions for managing projects and tasks, along with viewing user details. This includes the ability to create, view, update, and delete projects and tasks, assign tasks, update task statuses, and view user profiles.

* **`developer`**: Focused primarily on project and task execution. Developers can view any project and task, update task statuses, and view user details.

* **`user`**: Provides basic access. Users with this role can create, view, update, and delete their own projects and tasks, and view user details.

### Default Seeded Users

For convenient development and testing, the database seeder creates the following default user accounts:

| Email              | Password   | Role            |
| :----------------- | :--------- | :-------------- |
| `admin@example.com` | `password` | `admin`         |
| `pm@example.com`    | `password` | `project_manager`|
| `dev@example.com`   | `password` | `developer`     |
| `user@example.com`  | `password` | `user`          |

**Important:** For production environments, it is crucial to remove these default users or change their credentials immediately to maintain security.
