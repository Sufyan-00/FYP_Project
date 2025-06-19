# **Introduction**

## Purpose

This Software Requirements Specification (SRS) document specifies the requirements for the FYP Proposal Approval System for COMSATS University Islamabad, Vehari Campus. This document is intended for the development team, project supervisor, and evaluation committee members.

## Scope

The FYP Proposal Approval System aims to digitize and streamline the management of student projects in COMSATS University Islamabad, Vehari Campus. The system will facilitate project idea submission, supervisor allocation, scope document management, evaluation committee formation, and project tracking through a web-based interface.

Key features include:

- User management with role-based access
- Supervisor profile and research interest publication
- Project idea submission and approval workflow
- Scope document submission and management
- Evaluation committee management and scheduling
- Automated notifications and status reporting

The system will not implement or integrate with the CUI online system, will not include a mobile application, and will not provide suggestions for FYP ideas.

# **Overall Description**

## Product Perspective

The FYP Proposal Approval System will be a new, standalone web application designed to replace the current paper-based processes for managing final year projects at CUI Vehari. It will serve as a centralized platform connecting administrators (FYP committee), supervisors, students, and evaluation committee members.

## Operating Environment

OE-1: The system shall operate on standard web browsers including Google Chrome (version 90+), Mozilla Firefox (version 85+), Microsoft Edge (version 90+), and Safari (version 14+).

OE-2: The system shall be hosted on a web server running PHP 8.0+ with Laravel 8+ framework.

OE-3: The system shall utilize MySQL/PostgreSQL database for data storage.

OE-4: The system shall be accessible via the university's intranet and remotely through secure internet connections.

OE-5: The system shall support concurrent access by at least 200 users without performance degradation.

## Design and Implementation Constraints

CO-1: The system shall be developed using Laravel PHP framework version 8 or higher.

CO-2: The front-end shall be developed using Tailwind CSS and/or Bootstrap frameworks.

CO-3: The system shall follow Model-View-Controller (MVC) architecture.

CO-4: The system shall implement role-based access control (RBAC) to manage user permissions.

CO-5: All date-sensitive operations must adhere to time constraints defined by the FYP committee.

CO-6: The system must be developed within the timeframe specified in the project Gantt chart.

CO-7: The system shall store all documents in PDF format with a maximum size of 10MB per file.

# Requirements Identifying Technique

## Use Case Diagram

The following use case diagram illustrates the main interactions between system actors and system functions:

\[Note: In the actual document, a use case diagram would be inserted here showing the four main actors (Administrator/FYP Committee, Supervisor, Student, Evaluation Committee Member) and their interactions with the system\]

## Use Case Description

**Use Case: Submit Project Idea**

| **Field** | **Description** |
| --- | --- |
| Use Case ID: | UC-1 |
| Use Case Name: | Submit Project Idea |
| Actors: | Primary Actor: Student Secondary Actors: None |
| Description: | A student submits a project idea for supervisor approval during the idea submission phase. |
| Trigger: | Student initiates the project idea submission process. |
| Preconditions: | PRE-1. Student is logged into the system. PRE-2. The idea submission phase is active as defined by the FYP committee. |
| Postconditions: | POST-1. Project idea is stored in the system with status "Pending". POST-2. Supervisor is notified of the new project idea submission. |
| Normal Flow: | 1.0 Submit Project Idea 1. Student navigates to the "Submit Project Idea" section. 2. System displays the project idea submission form. 3. Student enters project title, description, objectives, and selects a supervisor from the available list. 4. Student submits the form. 5. System validates the form data. 6. System stores the project idea with "Pending" status. 7. System notifies the selected supervisor about the new project idea. 8. System confirms successful submission to the student. |
| Alternative Flows: | 1.1 Save as Draft 1. At step 4, student chooses to save the form as draft. 2. System saves the incomplete form with "Draft" status. 3. Student can return later to complete and submit the form. 4. Use case ends. |
| Exceptions: | E1: Invalid Form Data 1. At step 5, if the system detects invalid or incomplete data: 2. System displays appropriate error messages. 3. System returns to step 3, preserving valid entered data. E2: Submission Phase Closed 1. If the student attempts to access the submission form when the submission phase is closed: 2. System displays a message indicating the submission period is closed. 3. System shows the dates for the next submission phase if available. 4. Use case ends. |
| Business Rules: | BR-1: Students can submit a maximum of three project ideas. BR-2: Project idea submissions are only allowed during the designated submission phase set by the FYP committee. |
| Assumptions: | ASSUM-1: Students have basic knowledge of how to use web-based forms. |

**Use Case: Review and Approve Project Idea**

| **Field** | **Description** |
| --- | --- |
| Use Case ID: | UC-2 |
| Use Case Name: | Review and Approve Project Idea |
| Actors: | Primary Actor: Supervisor Secondary Actors: Student |
| Description: | A supervisor reviews a submitted project idea and decides whether to approve, reject, or request modifications. |
| Trigger: | Supervisor accesses a pending project idea for review. |
| Preconditions: | PRE-1. Supervisor is logged into the system. PRE-2. At least one project idea with "Pending" status is assigned to the supervisor. |
| Postconditions: | POST-1. Project idea status is updated to "Approved", "Rejected", or "Revision Required". POST-2. Student is notified of the supervisor's decision. POST-3. If approved, the project is marked as active for the student. |
| Normal Flow: | 1.0 Review and Approve Project Idea 1. Supervisor navigates to the "Pending Project Ideas" section. 2. System displays a list of pending project ideas submitted to the supervisor. 3. Supervisor selects a specific project idea to review. 4. System displays the complete project idea details. 5. Supervisor reviews the project idea. 6. Supervisor approves the project idea and optionally adds comments. 7. System updates the project status to "Approved". 8. System notifies the student of approval. 9. System adds the project to the supervisor's active projects list. |
| Alternative Flows: | 1.1 Reject Project Idea 1. At step 6, supervisor rejects the project idea and provides feedback. 2. System updates the project status to "Rejected". 3. System notifies the student of rejection with the provided feedback. 4. Use case ends. 1.2 Request Modification 1. At step 6, supervisor requests modifications to the project idea and provides specific feedback. 2. System updates the project status to "Revision Required". 3. System notifies the student of the needed revisions with the provided feedback. 4. Use case ends. |
| Exceptions: | E1: Review Period Expired 1. If the approval phase has ended when the supervisor attempts to submit a decision: 2. System notifies the supervisor that the review period has expired. 3. System escalates the pending project idea to the FYP committee for decision. 4. Use case ends. |
| Business Rules: | BR-1: Supervisors must review project ideas within 7 days of submission. BR-2: Supervisors can have a maximum of 8 active projects at any time. |
| Assumptions: | ASSUM-1: Supervisors have sufficient domain knowledge to evaluate project feasibility. |

**Use Case: Upload Scope Document**

| **Field** | **Description** |
| --- | --- |
| Use Case ID: | UC-3 |
| Use Case Name: | Upload Scope Document |
| Actors: | Primary Actor: Student Secondary Actors: Supervisor |
| Description: | A student uploads a scope document for an approved project idea during the scope document submission phase. |
| Trigger: | Student initiates the scope document upload process. |
| Preconditions: | PRE-1. Student is logged into the system. PRE-2. Student has an approved project idea. PRE-3. The scope document submission phase is active. |
| Postconditions: | POST-1. Scope document is stored in the system with status "Submitted". POST-2. Supervisor is notified of the scope document submission. |
| Normal Flow: | 1.0 Upload Scope Document 1. Student navigates to the "My Project" section. 2. System displays the approved project details with an option to upload scope document. 3. Student selects the "Upload Scope Document" option. 4. System displays the document upload form. 5. Student uploads the scope document file (PDF format) and submits. 6. System validates the file format and size. 7. System stores the scope document with "Submitted" status. 8. System notifies the supervisor about the scope document submission. 9. System confirms successful upload to the student. |
| Alternative Flows: | 1.1 Update Existing Scope Document 1. If a scope document already exists and hasn't been approved: 2. Student selects the "Update Scope Document" option. 3. System displays the current document and update form. 4. Student uploads the revised scope document. 5. System validates the file format and size. 6. System stores the revised document and maintains version history. 7. System notifies the supervisor about the updated document. 8. Use case ends. |
| Exceptions: | E1: Invalid File Format or Size 1. At step 6, if the file is not in PDF format or exceeds the size limit: 2. System displays an error message. 3. System prompts the student to upload a valid file. 4. Return to step 5. E2: Submission Phase Closed 1. If the student attempts to upload the scope document when the submission phase is closed: 2. System displays a message indicating the submission period is closed. 3. System shows the dates for the next submission phase if available. 4. Use case ends. |
| Business Rules: | BR-1: The scope document must be in PDF format and not exceed 10MB. BR-2: Scope document submissions are only allowed during the designated submission phase. |
| Assumptions: | ASSUM-1: Students have prepared scope documents according to the provided template. |

**Use Case: Schedule Defence Session**

| **Field** | **Description** |
| --- | --- |
| Use Case ID: | UC-4 |
| Use Case Name: | Schedule Defence Session |
| Actors: | Primary Actor: Administrator (FYP Committee) Secondary Actors: Supervisor, Student, Evaluation Committee Member |
| Description: | The FYP committee schedules defence sessions for projects with approved scope documents, assigning time slots, venues, and evaluation committee members. |
| Trigger: | Administrator initiates the defence scheduling process. |
| Preconditions: | PRE-1. Administrator is logged into the system. PRE-2. Project has an approved scope document. PRE-3. Defence scheduling phase is active. |
| Postconditions: | POST-1. Defence session is scheduled with assigned time, venue, and evaluation committee. POST-2. All stakeholders (students, supervisors, evaluation committee members) are notified of the schedule. |
| Normal Flow: | 1.0 Schedule Defence Session 1. Administrator navigates to the "Defence Scheduling" section. 2. System displays projects with approved scope documents ready for defence scheduling. 3. Administrator selects projects to schedule for defence. 4. System displays available time slots, venues, and evaluation committee members. 5. Administrator assigns time slot, venue, and evaluation committee members to each selected project. 6. Administrator confirms the schedule. 7. System stores the defence schedule. 8. System notifies all stakeholders (students, supervisors, evaluation committee members) about the schedule. 9. System confirms successful scheduling to the administrator. |
| Alternative Flows: | 1.1 Batch Scheduling 1. At step 3, administrator selects batch scheduling option. 2. System displays projects grouped by department or supervisor. 3. Administrator sets time range and venue for the batch. 4. System automatically distributes projects across available time slots. 5. Administrator reviews and adjusts the automated schedule if needed. 6. Continue at step 6 of normal flow. 1.2 Reschedule Defence Session 1. Administrator selects an already scheduled defence session. 2. System displays current schedule details. 3. Administrator modifies the time, venue, or evaluation committee members. 4. Administrator confirms the changes. 5. System updates the defence schedule. 6. System notifies all stakeholders of the changes. 7. Use case ends. |
| Exceptions: | E1: No Available Evaluation Committee 1. At step 4, if no evaluation committee members are available for required time slots: 2. System displays a warning message. 3. System suggests alternative dates with available committee members. 4. Administrator selects from suggested alternatives or adds new committee members. 5. Return to step 5 of normal flow. |
| Business Rules: | BR-1: Defence sessions should be scheduled at least 7 days in advance. BR-2: An evaluation committee must have at least 2 members. BR-3: A committee member cannot be scheduled for more than 5 consecutive defence sessions. |
| Assumptions: | ASSUM-1: Evaluation committee members are available during the defence scheduling phase. |

**Use Case: Generate Reports**

| **Field** | **Description** |
| --- | --- |
| Use Case ID: | UC-5 |
| Use Case Name: | Generate Reports |
| Actors: | Primary Actor: Administrator (FYP Committee) Secondary Actors: None |
| Description: | The FYP committee generates various reports for administrative purposes, including project status summaries, supervisor load distribution, and evaluation statistics. |
| Trigger: | Administrator initiates the report generation process. |
| Preconditions: | PRE-1. Administrator is logged into the system. PRE-2. Sufficient data exists in the system to generate meaningful reports. |
| Postconditions: | POST-1. Requested report is generated and displayed to the administrator. POST-2. Report can be exported in PDF or Excel format. |
| Normal Flow: | 1.0 Generate Reports 1. Administrator navigates to the "Reports" section. 2. System displays available report types (project status, supervisor load, evaluation statistics, etc.). 3. Administrator selects a report type. 4. System displays report parameters form (time period, department, etc.). 5. Administrator sets the parameters and submits. 6. System generates the report based on selected parameters. 7. System displays the report with visualization options. 8. Administrator reviews the report. 9. Administrator exports the report in desired format (PDF, Excel) if needed. |
| Alternative Flows: | 1.1 Schedule Automated Reports 1. At step 2, administrator selects "Schedule Reports" option. 2. System displays report scheduling form. 3. Administrator selects report type, frequency (weekly, monthly), delivery method (email), and recipients. 4. Administrator confirms the schedule. 5. System saves the report schedule. 6. Use case ends. |
| Exceptions: | E1: Insufficient Data 1. At step 6, if insufficient data exists to generate meaningful report: 2. System displays a message indicating insufficient data. 3. System suggests parameter adjustments to include more data. 4. Return to step 5 or terminate use case. |
| Business Rules: | BR-1: Reports must not include personally identifiable information except for authorized administrative purposes. BR-2: Historical reports should be available for at least 3 academic years. |
| Assumptions: | ASSUM-1: Administrator understands the metrics and statistics presented in the reports. |

# Specific Requirements

## User Management Module

**Functional Requirements**

| **Identifier** | **UM-1** |
| --- | --- |
| Title | User Registration |
| Requirement | The system shall allow the Administrator (FYP Committee) to upload a CSV file containing user data (Name, Email, Registration Number, Role) to create multiple user accounts at once. |
| Source | Project Proposal |
| Rationale | To efficiently create accounts for large numbers of students, supervisors, and committee members without manual entry of each user. |
| Business Rule | CSV file must contain required fields in the specified format. |
| Dependencies | None |
| Priority | High |

| **Identifier** | **UM-2** |
| --- | --- |
| Title | Role-Based Access Control |
| Requirement | The system shall restrict access to features based on user roles (Administrator, Supervisor, Student, Evaluation Committee Member), with each role having predefined permissions. |
| Source | Project Proposal |
| Rationale | To ensure users can only access features relevant to their role in the FYP process. |
| Business Rule | A user can be assigned multiple roles if necessary. |
| Dependencies | UM-1 |
| Priority | High |

| **Identifier** | **UM-3** |
| --- | --- |
| Title | User Authentication |
| Requirement | The system shall authenticate users through email and password, with password reset functionality via email verification. |
| Source | Project Proposal |
| Rationale | To secure access to the system and verify user identity. |
| Business Rule | Passwords must meet minimum security requirements (8+ characters, combination of letters, numbers, and special characters). |
| Dependencies | UM-1 |
| Priority | High |

| **Identifier** | **UM-4** |
| --- | --- |
| Title | User Profile Management |
| Requirement | The system shall allow users to update their profile information (contact details, profile picture) and change their password. |
| Source | Project Proposal |
| Rationale | To maintain accurate user information and allow users to manage their account security. |
| Business Rule | Email address changes require verification. |
| Dependencies | UM-1, UM-3 |
| Priority | Medium |

| **Identifier** | **UM-5** |
| --- | --- |
| Title | User Deactivation |
| Requirement | The system shall allow the Administrator to deactivate user accounts, preventing login while preserving historical data. |
| Source | Project Proposal |
| Rationale | To manage system access for users who have left the institution or completed their projects. |
| Business Rule | User accounts can be reactivated if needed. |
| Dependencies | UM-1 |
| Priority | Medium |

## Supervisor Profile Management Module

**Functional Requirements**

| **Identifier** | **SPM-1** |
| --- | --- |
| Title | Research Interest Publication |
| Requirement | The system shall allow Supervisors to create and publish their research interests, areas of expertise, and available project slots. |
| Source | Project Proposal |
| Rationale | To help students identify suitable supervisors based on their research interests. |
| Business Rule | Research interests must be published before the project idea submission phase begins. |
| Dependencies | UM-2 |
| Priority | High |

| **Identifier** | **SPM-2** |
| --- | --- |
| Title | Supervisor Project Capacity |
| Requirement | The system shall track the number of active projects per supervisor and enforce the maximum allowed limit (8 projects). |
| Source | Project Proposal |
| Rationale | To ensure supervisors maintain a manageable workload for effective guidance. |
| Business Rule | Supervisors cannot be assigned more than the maximum allowed projects. |
| Dependencies | SPM-1 |
| Priority | High |

| **Identifier** | **SPM-3** |
| --- | --- |
| Title | Supervisor Browse and Search |
| Requirement | The system shall allow Students to browse and search for Supervisors based on research interests, areas of expertise, and available slots. |
| Source | Project Proposal |
| Rationale | To facilitate the matching of students with appropriate supervisors. |
| Business Rule | Only active supervisors with available slots appear in search results during the selection phase. |
| Dependencies | SPM-1, SPM-2 |
| Priority | Medium |

| **Identifier** | **SPM-4** |
| --- | --- |
| Title | Supervisor Project History |
| Requirement | The system shall maintain a history of past projects supervised by each Supervisor, accessible to Students and Administrators. |
| Source | Project Proposal |
| Rationale | To provide insight into a supervisor's experience and project track record. |
| Business Rule | Only successfully completed projects are included in the history. |
| Dependencies | SPM-1 |
| Priority | Low |

## Project Idea and Approval Module

**Functional Requirements**

| **Identifier** | **PIA-1** |
| --- | --- |
| Title | Project Idea Submission |
| Requirement | The system shall allow Students to submit project ideas during the designated submission phase, including title, description, objectives, and selected supervisor. |
| Source | Project Proposal |
| Rationale | To capture project proposals in a structured format for evaluation. |
| Business Rule | Students can submit a maximum of three project ideas. |
| Dependencies | UM-2, SPM-3 |
| Priority | High |

| **Identifier** | **PIA-2** |
| --- | --- |
| Title | Project Idea Approval Workflow |
| Requirement | The system shall implement a workflow for Supervisors to review, approve, reject, or request modifications to submitted project ideas. |
| Source | Project Proposal |
| Rationale | To ensure project ideas meet quality standards and supervisor expectations. |
| Business Rule | Supervisors must provide feedback for rejected or revision-required projects. |
| Dependencies | PIA-1 |
| Priority | High |

| **Identifier** | **PIA-3** |
| --- | --- |
| Title | Project Status Tracking |
| Requirement | The system shall display the current status of project ideas (Draft, Pending, Approved, Rejected, Revision Required) to relevant stakeholders. |
| Source | Project Proposal |
| Rationale | To provide transparency in the approval process. |
| Business Rule | Status updates trigger appropriate notifications. |
| Dependencies | PIA-1, PIA-2 |
| Priority | Medium |

| **Identifier** | **PIA-4** |
| --- | --- |
| Title | Project Idea Modification |
| Requirement | The system shall allow Students to modify project ideas with "Revision Required" status based on supervisor feedback. |
| Source | Project Proposal |
| Rationale | To facilitate iterative refinement of project ideas. |
| Business Rule | Modified ideas must be resubmitted within 7 days of receiving revision request. |
| Dependencies | PIA-2, PIA-3 |
| Priority | Medium |

## Scope Document Management Module

**Functional Requirements**

| **Identifier** | **SDM-1** |
| --- | --- |
| Title | Scope Document Upload |
| Requirement | The system shall allow Students to upload scope documents for approved project ideas during the designated submission phase. |
| Source | Project Proposal |
| Rationale | To formalize project details and requirements through official documentation. |
| Business Rule | Documents must be in PDF format and not exceed 10MB. |
| Dependencies | PIA-2 |
| Priority | High |

| **Identifier** | **SDM-2** |
| --- | --- |
| Title | Scope Document Review |
| Requirement | The system shall enable Supervisors to review scope documents and provide feedback or approval. |
| Source | Project Proposal |
| Rationale | To ensure scope documents meet quality standards and project requirements. |
| Business Rule | Review must be completed within 7 days of submission. |
| Dependencies | SDM-1 |
| Priority | High |

| **Identifier** | **SDM-3** |
| --- | --- |
| Title | Scope Document Version Control |
| Requirement | The system shall maintain version history of scope documents, allowing access to previous versions. |
| Source | Project Proposal |
| Rationale | To track the evolution of project documentation and preserve all submission history. |
| Business Rule | All versions are stored but only the latest approved version is considered official. |
| Dependencies | SDM-1, SDM-2 |
| Priority | Medium |

| **Identifier** | **SDM-4** |
| --- | --- |
| Title | Document Template Management |
| Requirement | The system shall provide downloadable templates for scope documents and other required project documentation. |
| Source | Project Proposal |
| Rationale | To standardize document formats and ensure all required information is included. |
| Business Rule | Templates may be updated by the Administrator; changes do not affect previously submitted documents. |
| Dependencies | None |
| Priority | Medium |

## Evaluation Committee Management Module

**Functional Requirements**

| **Identifier** | **ECM-1** |
| --- | --- |
| Title | Committee Formation |
| Requirement | The system shall allow the Administrator to create evaluation committees by assigning faculty members with evaluation privileges. |
| Source | Project Proposal |
| Rationale | To establish official groups responsible for project evaluation. |
| Business Rule | Each committee must have at least 2 members. |
| Dependencies | UM-2 |
| Priority | High |

| **Identifier** | **ECM-2** |
| --- | --- |
| Title | Defence Session Scheduling |
| Requirement | The system shall enable the Administrator to schedule defence sessions by assigning time slots, venues, and evaluation committees to projects. |
| Source | Project Proposal |
| Rationale | To organize and communicate evaluation schedules to all stakeholders. |
| Business Rule | Defence sessions must be scheduled at least 7 days in advance. |
| Dependencies | ECM-1, SDM-2 |
| Priority | High |

| **Identifier** | **ECM-3** |
| --- | --- |
| Title | Evaluation Rubric Management |
| Requirement | The system shall provide customizable evaluation rubrics for committee members to assess projects. |
| Source | Project Proposal |
| Rationale | To standardize project evaluation and ensure fair assessment. |
| Business Rule | Rubrics can be customized by the Administrator before the evaluation phase begins. |
| Dependencies | ECM-1 |
| Priority | Medium |

| **Identifier** | **ECM-4** |
| --- | --- |
| Title | Evaluation Feedback Submission |
| Requirement | The system shall allow committee members to submit evaluation scores and feedback using the provided rubric during or after defence sessions. |
| Source | Project Proposal |
| Rationale | To capture and store evaluation results for each project. |
| Business Rule | Feedback must be submitted within 24 hours of the defence session. |
| Dependencies | ECM-2, ECM-3 |
| Priority | High |

## Notification and Reporting System Module

**Functional Requirements**

| **Identifier** | **NRS-1** |
| --- | --- |
| Title | Automated Notifications |
| Requirement | The system shall send automated notifications for key events (submission deadlines, status changes, scheduled defences) via email and in-system alerts. |
| Source | Project Proposal |
| Rationale | To keep stakeholders informed of important events and deadlines. |
| Business Rule | Users can configure notification preferences (email, in-system, or both). |
| Dependencies | Multiple |
| Priority | High |

| **Identifier** | **NRS-2** |
| --- | --- |
| Title | Deadline Reminders |
| Requirement | The system shall send reminder notifications at configurable intervals before important deadlines. |
| Source | Project Proposal |
| Rationale | To prevent missed deadlines and encourage timely submissions. |
| Business Rule | Reminders are sent 7 days, 3 days, and 1 day before deadlines. |
| Dependencies | NRS-1 |
| Priority | Medium |

| **Identifier** | **NRS-3** |
| --- | --- |
| Title | Administrative Reports |
| Requirement | The system shall generate customizable reports for the Administrator, including project status summaries, supervisor load distribution, and evaluation statistics. |
| Source | Project Proposal |
| Rationale | To provide insights for administrative decision-making and process improvement. |
| Business Rule | Reports can be exported in PDF or Excel format. |
| Dependencies | Multiple |
| Priority | Medium |

| **Identifier** | **NRS-4** |
| --- | --- |
| Title | Dashboard Visualization |
| Requirement | The system shall provide role-specific dashboards displaying relevant metrics and pending tasks. |
| Source | Project Proposal |
| Rationale | To give users quick access to important information and pending actions. |
| Business Rule | Dashboard content is filtered based on user role and permissions. |
| Dependencies | Multiple |
| Priority | Medium |

# Non-Functional Requirements

## Usability

USE-1: The system shall have an intuitive user interface requiring no specialized training for basic operations.

USE-2: The system shall provide contextual help and tooltips for complex features.

USE-3: The system shall be accessible on devices with various screen sizes (responsive design).

USE-4: The system shall display clear error messages with suggested corrective actions.

USE-5: The system shall maintain consistent navigation and design patterns throughout all pages.

## Performance

PER-1: The system shall load all pages within 3 seconds under normal load conditions (up to 100 concurrent users).

PER-2: The system shall handle file uploads (up to 10MB) within 10 seconds under normal network conditions.

PER-3: The system shall support at least 200 concurrent users without performance degradation.

PER-4: Database queries shall return results within 2 seconds under normal load conditions.

PER-5: The system shall maintain a 99% uptime during academic semesters.

## Security

SEC-1: The system shall encrypt all passwords using industry-standard hashing algorithms.

SEC-2: The system shall implement session timeout after 30 minutes of inactivity.

SEC-3: The system shall protect against common web vulnerabilities (SQL injection, XSS, CSRF).

SEC-4: The system shall maintain an audit log of all critical operations (login attempts, data modifications).

SEC-5: The system shall enforce HTTPS for all communications.

## Reliability

REL-1: The system shall perform automated database backups daily.

REL-2: The system shall recover from crashes without data loss (transactions shall be atomic).

REL-3: The system shall provide graceful degradation of functionality in case of component failures.

REL-4: The system shall implement error logging for all critical operations to assist in troubleshooting.

REL-5: The system shall handle concurrent access to shared resources without data corruption.

## External Interface Requirements

## User Interfaces

UI-1: The system shall provide a web-based interface accessible through standard web browsers.

UI-2: The user interface shall be responsive and support various screen sizes (desktop, tablet, mobile).

UI-3: The user interface shall provide role-based dashboards displaying relevant information and pending tasks.

UI-4: The system shall implement a consistent navigation structure across all pages with clear breadcrumbs. UI-5: Form elements shall provide inline validation with immediate feedback on input errors. UI-6: The system shall support document preview for uploaded PDF files without requiring download.

## Software Interfaces

SI-1: The system shall interface with the university email system to send notifications.

SI-2: The system shall provide an API for potential future integration with the university's central information system.

SI-3: The system shall support export of data to common formats (PDF, Excel) for reporting purposes.

SI-4: The system shall interface with the university's authentication system if available (optional).

## Hardware Interfaces

HI-1: The system shall operate on standard server hardware with the following minimum specifications:

- CPU: Quad-core processor @ 2.5 GHz
- RAM: 8 GB
- Storage: 100 GB SSD
- Network: 1 Gbps Ethernet connection

HI-2: The system shall support standard input/output devices (keyboard, mouse, monitor).

HI-3: The system shall not require specialized hardware components for normal operation.

## Communications Interfaces

CI-1: The system shall use HTTP/HTTPS protocols for all client-server communications.

CI-2: The system shall use SMTP protocol for email notifications.

CI-3: The system shall support secure WebSocket connections for real-time notifications.

CI-4: The system shall implement appropriate security measures for all communications (TLS 1.3 or higher).

CI-5: The system shall handle network interruptions gracefully, allowing users to resume activities when connection is restored.

# Project Gantt Chart

The Gantt chart below outlines the development timeline for the FYP Proposal Approval System:

| **Task** | **Duration** | **Start Date** | **End Date** | **Dependencies** |
| --- | --- | --- | --- | --- |
| Requirements Analysis | 2 weeks | 15-May-2025 | 29-May-2025 | \-  |
| System Design | 3 weeks | 30-May-2025 | 20-Jun-2025 | Requirements Analysis |
| Database Design | 2 weeks | 30-May-2025 | 13-Jun-2025 | Requirements Analysis |
| Frontend Development | 6 weeks | 21-Jun-2025 | 01-Aug-2025 | System Design |
| Backend Development | 8 weeks | 21-Jun-2025 | 15-Aug-2025 | System Design, Database Design |
| User Management Module | 2 weeks | 21-Jun-2025 | 04-Jul-2025 | Database Design |
| Supervisor Profile Module | 2 weeks | 05-Jul-2025 | 18-Jul-2025 | User Management Module |
| Project Idea Module | 2 weeks | 19-Jul-2025 | 01-Aug-2025 | Supervisor Profile Module |
| Scope Document Module | 2 weeks | 02-Aug-2025 | 15-Aug-2025 | Project Idea Module |
| Evaluation Committee Module | 2 weeks | 16-Aug-2025 | 29-Aug-2025 | Scope Document Module |
| Notification System | 1 week | 30-Aug-2025 | 05-Sep-2025 | All previous modules |
| Integration Testing | 3 weeks | 06-Sep-2025 | 26-Sep-2025 | All development tasks |
| User Acceptance Testing | 2 weeks | 27-Sep-2025 | 10-Oct-2025 | Integration Testing |
| Bug Fixing and Improvements | 2 weeks | 11-Oct-2025 | 24-Oct-2025 | User Acceptance Testing |
| Deployment | 1 week | 25-Oct-2025 | 31-Oct-2025 | Bug Fixing and Improvements |
| Training and Documentation | 2 weeks | 01-Nov-2025 | 14-Nov-2025 | Deployment |

# References

1. IEEE Std 830-1998, IEEE Recommended Practice for Software Requirements Specifications.
2. COMSATS University Islamabad, "Final Year Project Guidelines," 2024.
3. Sommerville, I. (2022). Software Engineering (11th ed.). Pearson Education Limited.
4. Laravel Documentation (2024). <https://laravel.com/docs/>
5. MySQL Documentation (2024). <https://dev.mysql.com/doc/>
6. Tailwind CSS Documentation (2024). <https://tailwindcss.com/docs>
7. Bootstrap Documentation (2024). <https://getbootstrap.com/docs/>
8. PHP Documentation (2024). <https://www.php.net/docs.php>
