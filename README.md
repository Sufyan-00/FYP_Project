# FYP Proposal Approval System (CUI Vehari)

A comprehensive web-based platform designed to digitize and automate the Final Year Project (FYP) management process at COMSATS University Islamabad, Vehari Campus. This system replaces traditional paper-based workflows with a streamlined, transparent, and efficient digital environment.

---

## 🚀 Project Overview

The traditional manual process for managing student projects often suffers from slow approval workflows, lack of transparency, and inefficient communication. This project solves these challenges by providing a centralized platform for the entire FYP lifecycle—from initial idea submission to final defense evaluation.

### Key Success Metrics:
* **Efficiency:** Reduces processing time for project approvals by 60-70%.
* **Transparency:** Real-time status tracking for all stakeholders.
* **Accuracy:** Intelligent scheduling and capacity enforcement to eliminate human error.

---

## 🛠 Tech Stack

* **Framework:** Laravel 12
* **Language:** PHP 8.0+
* **Database:** MySQL 8.0
* **Frontend:** Tailwind CSS & Laravel Blade Templates
* **Security:** Laravel Sanctum & Bcrypt Hashing

---

## 👥 System Roles & Actors

The system utilizes Role-Based Access Control (RBAC) to ensure secure access for four primary user types:

| Role | Key Responsibilities |
| :--- | :--- |
| **Student** | Submit project ideas (max 3), upload scope documents, and track status. |
| **Supervisor** | Publish research interests, review ideas, and manage workload (max 8 projects). |
| **Administrator** | Manage users, form evaluation committees, and schedule defense sessions. |
| **Committee Member** | Review projects and submit feedback via standardized digital rubrics. |

---

## ✨ Core Features

### 1. Automated Workflow
The system manages a linear workflow:
1. Supervisor publishes interests.
2. Student submits idea.
3. Supervisor reviews (Approve/Reject/Revision Required).
4. Student uploads Scope Document (PDF <10MB).
5. Administrator schedules Defense.

### 2. Intelligent Defense Scheduling
The system features a conflict detection algorithm that prevents double-booking for:
* **Venues:** Ensures a room isn't used for two defenses at once.
* **Faculty:** Ensures committee members aren't scheduled for overlapping sessions.
* **Buffers:** Enforces a mandatory 30-minute buffer between sessions.

### 3. Supervisor Capacity Tracking
To ensure quality mentorship, the system enforces a "Hard Cap" of 8 active projects per supervisor. The system automatically disables a supervisor's "accept" button once they reach their assigned limit (default is 6).

---

## 📊 System Design

### Entity-Relationship Diagram (ERD)
The database follows a normalized relational model to handle complex many-to-many relationships between faculty, students, and committees.



### Data Flow Diagram (DFD Level 1)
This diagram illustrates how data moves through the functional modules of the system, including User Management and Project Handling.



---

## 🔒 Security & Performance

* **Attack Protection:** Built-in protection against SQL Injection, XSS, and CSRF attacks.
* **Encrypted Storage:** All passwords are hashed using **bcrypt** with unique salts.
* **High Availability:** Designed for 99.5% uptime and 200 concurrent users.
* **Responsive UI:** Fully mobile-responsive design for access on tablets and phones.
