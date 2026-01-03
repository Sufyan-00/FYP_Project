# FYP Proposal Approval System (CUI Vehari)

[cite_start]A comprehensive web-based platform designed to digitize and automate the Final Year Project (FYP) management process at COMSATS University Islamabad, Vehari Campus[cite: 8, 29]. [cite_start]This system replaces traditional paper-based workflows with a streamlined, transparent, and efficient digital environment[cite: 32, 115].

---

## 🚀 Project Overview

[cite_start]The current manual process for managing student projects often suffers from slow approval workflows, lack of transparency, and inefficient communication[cite: 30]. [cite_start]This project solves these challenges by providing a centralized platform for the entire FYP lifecycle—from initial idea submission to final defense evaluation[cite: 32].

### Key Benefits:
* [cite_start]**Efficiency:** Reduces processing time for project approvals by approximately 60-70%[cite: 42].
* [cite_start]**Transparency:** Provides real-time status tracking for students and faculty[cite: 34, 43].
* [cite_start]**Automation:** Intelligent scheduling and capacity enforcement reduce administrative burden[cite: 38, 406].

---

## 🛠 Tech Stack

* [cite_start]**Framework:** Laravel 12 [cite: 37, 137]
* [cite_start]**Language:** PHP 8.0+ [cite: 37, 118]
* [cite_start]**Database:** MySQL [cite: 37, 139]
* [cite_start]**Frontend:** Tailwind CSS & Laravel Blade Templates [cite: 117, 138]
* [cite_start]**Security:** Laravel Sanctum & Bcrypt Hashing [cite: 40, 140]

---

## 👥 System Roles & Actors

[cite_start]The system utilizes Role-Based Access Control (RBAC) to ensure secure and relevant access for four primary user types[cite: 33, 177]:

| Role | Key Responsibilities |
| :--- | :--- |
| **Student** | [cite_start]Submit project ideas (max 3), upload scope documents, and track approval status[cite: 34, 236]. |
| **Supervisor** | [cite_start]Publish research interests, review project ideas, and manage project workloads (max 8 active projects)[cite: 35, 213]. |
| **Administrator** | [cite_start]Manage user accounts via CSV import, form evaluation committees, and schedule defense sessions[cite: 36, 173]. |
| **Committee Member** | [cite_start]Review projects, conduct defenses, and submit feedback via digital rubrics[cite: 341, 348]. |

---

## ✨ Core Modules

### [cite_start]1. Project Idea & Approval [cite: 123]
[cite_start]Students browse supervisor profiles to find matches for their research interests[cite: 216]. [cite_start]Once an idea is submitted, supervisors can approve, reject, or request revisions[cite: 385].

### [cite_start]2. Scope Document Management [cite: 124]
Approved projects move to the documentation phase. [cite_start]The system supports PDF uploads (up to 10MB) and maintains version control to track document evolution[cite: 258, 268].

### [cite_start]3. Evaluation Committee Management [cite: 125]
[cite_start]Administrators form committees of at least two faculty members[cite: 285]. [cite_start]The system automates defense scheduling with built-in conflict detection for venues and participants[cite: 290, 1333].

### [cite_start]4. Administrative Dashboard [cite: 126]
[cite_start]A comprehensive dashboard provides real-time analytics, project metrics, and the ability to export reports in PDF or Excel formats[cite: 73, 310, 318].

---

## 📊 Design Architecture

### Entity-Relationship Diagram (ERD)
[cite_start]The system uses a normalized relational schema to ensure data integrity across users, projects, and evaluations[cite: 987, 988].



### System Workflow (DFD Level 0)
[cite_start]The context diagram illustrates the high-level information flow between the system and its four primary actors[cite: 563, 571].



---

## 🔒 Security Features

* [cite_start]**Input Validation:** Protects against SQL Injection, XSS, and CSRF attacks[cite: 40, 467].
* [cite_start]**Password Security:** All credentials are encrypted using the bcrypt algorithm[cite: 40, 458].
* [cite_start]**Session Management:** Automatic session timeout after 30 minutes of inactivity[cite: 473].
* [cite_start]**Audit Logging:** Critical user actions are logged with timestamps for accountability[cite: 546].

---

## ⚙️ Installation Requirements

### [cite_start]Hardware Baseline[cite: 1138, 1140]:
* **App Server:** 2 vCPU, 4 GB RAM.
* **DB Server:** 4 vCPU, 8 GB RAM (MySQL 8).

### [cite_start]Software Stack[cite: 1144, 1146]:
* **OS:** Ubuntu LTS or Windows.
* **Web Server:** Nginx 1.24+.
* **Runtime:** PHP 8.3+, Node.js 20+.
