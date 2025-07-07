1.	Introduction
1.1.	Purpose
This Software Requirements Specification (SRS) document specifies the requirements for the FYP Proposal Approval System for COMSATS University Islamabad, Vehari Campus. This document is intended for the development team, project supervisor, and evaluation committee members.
1.2.	Scope
The FYP Proposal Approval System aims to digitise and streamline the management of student projects in COMSATS University Islamabad, Vehari Campus. The system will facilitate project idea submission, supervisor allocation, scope document management, evaluation committee formation, and project tracking through a web-based interface.
Key features include:
•	User management with role-based access
•	Supervisor profile and research interest publication
•	Project idea submission and approval workflow
•	Scope document submission and management
•	Evaluation committee management and scheduling
•	Automated notifications and status reporting
The system will not implement or integrate with the CUI online system, will not include a mobile application, and will not provide suggestions for FYP ideas.
2.	Overall Description
2.1.	Product Perspective
The FYP Proposal Approval System will be a new, standalone web application designed to replace the current paper-based processes for managing final year projects at CUI Vehari. It will serve as a centralised platform connecting administrators (FYP committee), supervisors, students, and evaluation committee members.
2.2.	Operating Environment
OE-1: The system shall operate on standard web browsers, including Google Chrome, Mozilla Firefox, Microsoft Edge and Safari.
OE-2: The system shall be hosted on a web server running PHP 8.0 with the Laravel 8 framework.
OE-3: The system shall utilise MySQL/PostgreSQL database for data storage.
OE-4: The system shall be accessible via the university's intranet and remotely through secure internet connections.
OE-5: The system shall support concurrent access by at least 200 users without performance degradation.
2.3.	Design and Implementation Constraints
CO-1: The system shall be developed using the Laravel PHP framework version 8 or higher.
CO2: The front-end shall be developed using Tailwind CSS and/or Bootstrap frameworks.
CO-3: The system shall follow Model-View-Controller (MVC) architecture.
CO-4: The system shall implement role-based access control (RBAC) to manage user permissions.
CO-5: All date-sensitive operations must adhere to time constraints defined by the FYP committee.
CO-6: The system must be developed within the timeframe specified in the project Gantt chart.
CO-7: The system shall store all documents in PDF format with a maximum size of 10MB per file.
3.	Requirements Identifying Technique
3.1.	Use Case Diagram
The following use case diagram illustrates the main interactions between system actors and system functions:  


3.2.	Use Case Descriptions
Use Case: Submit Project Idea
Use Case ID:	UC-1
Use Case Name:	Submit Project Idea
Actors:	Primary Actor: Student
Secondary Actors: None
Description:	A student submits a project idea for supervisor approval during the idea submission phase.
Trigger:	Student initiates the project idea submission process.
Preconditions:	PRE-1. The student is logged into the system.
PRE-2. The idea submission phase is active as defined by the FYP committee.
Postconditions:	POST-1. The project idea is stored in the system with status "Pending".
POST-2. The supervisor is notified of the new project idea submission.
Normal Flow:	1.0 Submit Project Idea
1. Student navigates to the "Submit Project Idea" section.
2. The system displays the project idea submission form.
3. Student enters project title, description, objectives, and selects a supervisor from the available list.
4. The student submits the form.
5. The system validates the form data.
6. The system stores the project idea with "Pending" status.
7. The system notifies the selected supervisor about the new project idea.
8. The system confirms successful submission to the student.
Alternative Flows:	1.1 Save as Draft
1. At step 4, the student chooses to save the form as a draft.
2. The system saves the incomplete form with "Draft" status.
3. The student can return later to complete and submit the form.
4. Use case ends.
Exceptions:	E1: Invalid Form Data
1. At step 5, if the system detects invalid or incomplete data.
2. The System displays appropriate error messages.
3. The system returns to step 3, preserving valid entered data.

E2: Submission Phase Closed
1. If the student attempts to access the submission form when the submission phase is closed,
2. The system displays a message indicating the submission period is closed.
3. The system shows the dates for the next submission phase if available.
4. Use case ends.
Business Rules:	BR-1: Students can submit a maximum of three project ideas.
BR-2: Project idea submissions are only allowed during the designated submission phase set by the FYP committee.
Assumptions:	ASSUM-1: Students have basic knowledge of how to use web-based forms.

Use Case: Review and Approve Project Idea
Use Case ID:	UC-2
Use Case Name:	Review and Approve Project Idea
Actors:	Primary Actor: Supervisor
Secondary Actors: Student
Description:	A supervisor reviews a submitted project idea and decides whether to approve, reject, or request modifications.
Trigger:	Supervisor accesses a pending project idea for review.
Preconditions:	PRE-1. The supervisor is logged into the system.
PRE-2. At least one project idea with "Pending" status is assigned to the supervisor.
Postconditions:	POST-1. Project idea status is updated to "Approved", "Rejected", or "Revision Required".
POST-2. The student is notified of the supervisor's decision.
POST-3. If approved, the project is marked as active for the student.
Normal Flow:	1.0 Review and Approve Project Idea
1. The supervisor navigates to the "Pending Project Ideas" section.
2. The system displays a list of pending project ideas submitted to the supervisor.
3. The supervisor selects a specific project idea to review.
4. The system displays the complete details of the project idea.
5. The supervisor reviews the project idea.
6. Supervisor approves the project idea and optionally adds comments.
7. System updates the project status to "Approved".
8. The system notifies the student of approval.
9. The system adds the project to the supervisor's active projects list.
Alternative Flows:	1.1 Reject Project Idea
1. At step 6, the supervisor rejects the project idea and provides feedback.
2. System updates the project status to "Rejected".
3. The system notifies the student of rejection with the provided feedback.
4. Use case ends.

1.2 Request Modification
1. At step 6, the supervisor requests modifications to the project idea and provides specific feedback.
2. System updates the project status to "Revision Required".
3. The system notifies the student of the needed revisions with the provided feedback.
4. Use case ends.
Exceptions:	E1: Review Period Expired
1. If the approval phase has ended, when the supervisor attempts to submit a decision,
2. The system notifies the supervisor that the review period has expired.
3. The system escalates the pending project idea to the FYP committee for decision.
4. Use case ends.
Business Rules:	BR-1: Supervisors must review project ideas within 7 days of submission.
BR-2: Supervisors can have a maximum of 8 active projects at any time.
Assumptions:	ASSUM-1: Supervisors have sufficient domain knowledge to evaluate project feasibility.

Use Case: Schedule Defence Session
Use Case ID:	UC-4
Use Case Name:	Schedule Defence Session
Actors:	Primary Actor: Administrator (FYP Committee)
Secondary Actors: Supervisor, Student, Evaluation Committee Member
Description:	The FYP committee schedules defence sessions for projects with approved scope documents, assigning time slots, venues, and evaluation committee members.
Trigger:	The administrator initiates the defence scheduling process.
Preconditions:	PRE-1. The administrator is logged into the system.
PRE-2. The project has an approved scope document.
PRE-3. The defence scheduling phase is active.
Postconditions:	POST-1. The defence session is scheduled with the assigned time, venue, and evaluation committee.
POST-2. All stakeholders (students, supervisors, and evaluation committee members) are notified of the schedule.
Normal Flow:	1.0 Schedule Defence Session
1. The administrator navigates to the "Defence Scheduling" section.
2. The system displays projects with approved scope documents ready for defence scheduling.
3. Administrator selects projects to schedule for defence.
4. System displays available time slots, venues, and evaluation committee members.
5. Administrator assigns time slot, venue, and evaluation committee members to each selected project.
6. Administrator confirms the schedule.
7. The system stores the defence schedule.
8. The system notifies all stakeholders about the schedule.
9. The system confirms successful scheduling to the administrator.
Alternative Flows:	1.1 Batch Scheduling
1. At step 3, the administrator selects the batch scheduling option.
2. The system displays projects grouped by department or supervisor.
3. Administrator sets the time range and venue for the batch.
4. The system automatically distributes projects across available time slots.
5. Administrator reviews and adjusts the automated schedule if needed.
6. Continue at step 6 of normal flow.
Exceptions:	E1: No Available Evaluation Committee
1. At step 4, if no evaluation committee members are available for the required time slots:
2. The System displays a warning message.
3. The system suggests alternative dates with available committee members.
4. Administrator selects from suggested alternatives or adds new committee members.
5. Return to step 5 of normal flow.
Business Rules:	BR-1: Defence sessions should be scheduled at least 7 days in advance.
BR-2: An evaluation committee must have at least 2 members.
BR-3: A committee member cannot be scheduled for more than 5 consecutive defence sessions.
Assumptions:	ASSUM-1: Evaluation committee members are available during the defence scheduling phase.

4.	Specific Requirements
4.1.	User Management Module
Identifier	UM-1
Title	User Registration
Requirement	The system shall allow the Administrator to upload a CSV file containing user data to create multiple user accounts at once.
Source	Project Proposal
Rationale	To efficiently create accounts for large numbers of users without manual entry.
Business Rule	The CSV file must contain the required fields in the specified format.
Dependencies	None
Priority	High
Identifier	UM-2
Title	Role-Based Access Control
Requirement	The system shall restrict access to features based on user roles, with each role having predefined permissions.
Source	Project Proposal
Rationale	To ensure that users can only access features relevant to their role.
Business Rule	A user can be assigned multiple roles if necessary.
Dependencies	UM-1
Priority	High
Identifier	UM-3
Title	User Authentication
Requirement	The system shall authenticate users through email and password, with password reset functionality via email.
Source	Project Proposal
Rationale	To secure access to the system and verify user identity.
Business Rule	Passwords must meet minimum security requirements.
Dependencies	UM-1
Priority	High
Identifier	UM-4
Title	User Profile Management
Requirement	The system shall allow users to update their profile information and change their password.
Source	Project Proposal
Rationale	To maintain accurate user information and account security.
Business Rule	Email address changes require verification.
Dependencies	UM-1, UM-3
Priority	Medium
Identifier	UM-5
Title	User Deactivation
Requirement	The system shall allow the Administrator to deactivate user accounts while preserving historical data.
Source	Project Proposal
Rationale	To manage system access for users who have left the institution.
Business Rule	User accounts can be reactivated if needed.
Dependencies	UM-1
Priority	Medium

4.2.	Supervisor Profile Management Module
Identifier	SPM-1
Title	Research Interest Publication
Requirement	The system shall allow Supervisors to create and publish their research interests and available project slots.
Source	Project Proposal
Rationale	To help students identify suitable supervisors based on research interests.
Business Rule	Research interests must be published before the submission phase begins.
Dependencies	UM-2
Priority	High
Identifier	SPM-2
Title	Supervisor Project Capacity
Requirement	The system shall track active projects per supervisor and enforce the maximum allowed limit.
Source	Project Proposal
Rationale	To ensure that supervisors maintain a manageable workload.
Business Rule	Supervisors cannot exceed the maximum allowed projects (8).
Dependencies	SPM-1
Priority	High
Identifier	SPM-3
Title	Supervisor Browse and Search
Requirement	The system shall allow Students to browse and search for Supervisors based on research interests and available slots.
Source	Project Proposal
Rationale	To facilitate matching students with appropriate supervisors.
Business Rule	Only active supervisors with available slots appear in search results.
Dependencies	SPM-1, SPM-2
Priority	Medium
Identifier	SPM-4
Title	Supervisor Project History
Requirement	The system shall maintain a history of past projects supervised by each Supervisor.
Source	Project Proposal
Rationale	To provide insight into a supervisor's experience and project track record.
Business Rule	Only completed projects are included in the history.
Dependencies	SPM-1
Priority	Low


4.3.	Project Idea and Approval Module
Identifier	PIA-1
Title	Project Idea Submission
Requirement	The system shall allow Students to submit project ideas during the designated submission phase.
Source	Project Proposal
Rationale	To capture project proposals in a structured format for evaluation.
Business Rule	Students can submit a maximum of three project ideas.
Dependencies	UM-2, SPM-3
Priority	High
Identifier	PIA-2
Title	Project Idea Approval Workflow
Requirement	The system shall implement a workflow for Supervisors to review and respond to submitted project ideas.
Source	Project Proposal
Rationale	To ensure project ideas meet quality standards and supervisor expectations.
Business Rule	Supervisors must provide feedback for rejected or revision-required projects.
Dependencies	PIA-1
Priority	High
Identifier	PIA-3
Title	Project Status Tracking
Requirement	The system shall display the current status of project ideas to relevant stakeholders.
Source	Project Proposal
Rationale	To provide transparency in the approval process.
Business Rule	Status updates trigger appropriate notifications.
Dependencies	PIA-1, PIA-2
Priority	Medium
Identifier	PIA-4
Title	Project Idea Modification
Requirement	The system shall allow Students to modify project ideas with "Revision Required" status.
Source	Project Proposal
Rationale	To facilitate iterative refinement of project ideas.
Business Rule	Modified ideas must be resubmitted within 7 days of the revision request.
Dependencies	PIA-2, PIA-3
Priority	Medium

4.4.	Scope Document Management Module
Identifier	SDM-1
Title	Scope Document Upload
Requirement	The system shall allow Students to upload scope documents for approved project ideas.
Source	Project Proposal
Rationale	To formalise project details through official documentation.
Business Rule	Documents must be in PDF format and not exceed 10MB.
Dependencies	PIA-2
Priority	High
Identifier	SDM-2
Title	Scope Document Review
Requirement	The system shall enable Supervisors to review scope documents and provide feedback or approval.
Source	Project Proposal
Rationale	To ensure documents meet quality standards and project requirements.
Business Rule	Review must be completed within 7 days of submission.
Dependencies	SDM-1
Priority	High
Identifier	SDM-3
Title	Scope Document Version Control
Requirement	The system shall maintain a version history of scope documents, allowing access to previous versions.
Source	Project Proposal
Rationale	To track document evolution and preserve submission history.
Business Rule	Only the latest approved version is considered official.
Dependencies	SDM-1, SDM-2
Priority	Medium
Identifier	SDM-4
Title	Document Template Management
Requirement	The system shall provide downloadable templates for scope documents and other required documentation.
Source	Project Proposal
Rationale	To standardise document formats and ensure completeness.
Business Rule	Template updates do not affect previously submitted documents.
Dependencies	None
Priority	Medium

4.5.	Evaluation Committee Management Module
Identifier	ECM-1
Title	Committee Formation
Requirement	The system shall allow the Administrator to create evaluation committees with assigned faculty members.
Source	Project Proposal
Rationale	To establish official groups responsible for project evaluation.
Business Rule	Each committee must have at least 2 members.
Dependencies	UM-2
Priority	High
Identifier	ECM-2
Title	Defence Session Scheduling
Requirement	The system shall enable scheduling defence sessions with assigned time slots, venues, and committees.
Source	Project Proposal
Rationale	To organise and communicate evaluation schedules efficiently.
Business Rule	Sessions must be scheduled at least 7 days in advance.
Dependencies	ECM-1, SDM-2
Priority	High
Identifier	ECM-3
Title	Evaluation Rubric for Management
Requirement	The system shall provide customizable evaluation rubrics for committee members to assess projects.
Source	Project Proposal
Rationale	To standardise project evaluation and ensure fair assessment.
Business Rule	Rubrics must be finalised before the evaluation phase begins.
Dependencies	ECM-1
Priority	Medium
Identifier	ECM-4
Title	Evaluation Feedback Submission
Requirement	The system shall allow committee members to submit evaluation scores and feedback using the provided rubric.
Source	Project Proposal
Rationale	To capture and store evaluation results for each project.
Business Rule	Feedback must be submitted within 24 hours of the defence session.
Dependencies	ECM-2, ECM-3
Priority	High

4.6.	Notification and Reporting System Module
Identifier	NRS-1
Title	Automated Notifications
Requirement	The system shall send automated notifications for key events via email and in-system alerts.
Source	Project Proposal
Rationale	To keep stakeholders informed of important events and deadlines.
Business Rule	Users can configure notification preferences.
Dependencies	Multiple
Priority	High
Identifier	NRS-2
Title	Deadline Reminders
Requirement	The system shall send reminder notifications at configurable intervals before important deadlines.
Source	Project Proposal
Rationale	To prevent missed deadlines and encourage timely submissions.
Business Rule	Reminders are sent 7, 3, and 1 day before deadlines.
Dependencies	NRS-1
Priority	Medium
Identifier	NRS-3
Title	Administrative Reports
Requirement	The system shall generate customizable reports for the Administrator with key project metrics.
Source	Project Proposal
Rationale	To provide insights for administrative decision-making.
Business Rule	Reports can be exported in PDF or Excel format.
Dependencies	Multiple
Priority	Medium
Identifier	NRS-4
Title	Dashboard Visualization
Requirement	The system shall provide role-specific dashboards displaying relevant metrics and pending tasks.
Source	Project Proposal
Rationale	To provide quick access to important information.
Business Rule	Dashboard content is filtered based on user role.
Dependencies	Multiple
Priority	Medium
5.	Non-Functional Requirements
5.1.	Usability
USE-1: The system shall have an intuitive user interface requiring no specialised training for basic operations.
USE-2: The system shall provide contextual help and tooltips for complex features.
USE-3: The system shall be accessible on devices with various screen sizes (responsive design).
USE-4: The system shall display clear error messages with suggested corrective actions.
USE-5: The system shall maintain consistent navigation and design patterns throughout all pages.
5.2.	Performance
PER-1: The system shall load all pages within 3 seconds under normal load conditions (up to 100 concurrent users).
PER-2: The system shall handle file uploads (up to 10MB) within 10 seconds under normal network conditions.
PER-3: The system shall support at least 200 concurrent users without performance degradation.
PER-4: Database queries shall return results within 2 seconds under normal load conditions.
PER-5: The system shall maintain a 99% uptime during academic semesters.
5.3.	Security
SEC-1: The system shall encrypt all passwords using industry-standard hashing algorithms.
SEC-2: The system shall implement a session timeout after 30 minutes of inactivity.
SEC-3: The system shall protect against common web vulnerabilities (SQL injection, XSS, CSRF).
SEC-4: The system shall maintain an audit log of all critical operations (login attempts, data modifications).
SEC-5: The system shall enforce HTTPS for all communications.
5.4.	Reliability
REL-1: The system shall perform automated database backups daily. 
REL-2: The system shall recover from crashes without data loss (transactions shall be atomic). 
REL-3: The system shall provide graceful degradation of functionality in case of component failures. 
REL-4: The system shall implement error logging for all critical operations to assist in troubleshooting. 
REL-5: The system shall handle concurrent access to shared resources without data corruption.
6.	External Interface Requirements
6.1.	User Interfaces
UI-1: The system shall provide a web-based interface accessible through standard web browsers. 
UI-2: The user interface shall be responsive and support various screen sizes (desktop, tablet, mobile). 
UI-3: The user interface shall provide role-based dashboards displaying relevant information and pending tasks. 
UI-4: The system shall implement a consistent navigation structure across all pages with clear breadcrumbs.
UI-5: Form elements shall provide inline validation with immediate feedback on input errors.
UI-6: The system shall support document preview for uploaded PDF files without requiring download.
6.2.	Software Interfaces
SI-1: The system shall interface with the university email system to send notifications.
SI-2: The system shall provide an API for potential future integration with the university's central information system. 
SI-3: The system shall support export of data to common formats (PDF, Excel) for reporting purposes. 
SI-4: The system shall interface with the university's authentication system if available (optional).
6.3.	Hardware Interfaces
HI-1: The system shall operate on standard server hardware with the following minimum specifications:
•	CPU: Quad-core processor @ 2.5 GHz
•	RAM: 8 GB
•	Storage: 100 GB SSD
•	Network: 1 Gbps Ethernet connection
HI-2: The system shall support standard input/output devices (keyboard, mouse, monitor). 
HI-3: The system shall not require specialised hardware components for normal operation.
6.4.	Communications Interfaces
CI-1: The system shall use HTTP/HTTPS protocols for all client-server communications.
CI-2: The system shall use the SMTP protocol for email notifications. 
CI-3: The system shall support secure WebSocket connections for real-time notifications. 
CI-4: The system shall implement appropriate security measures for all communications (TLS 1.3 or higher). 
CI-5: The system shall handle network interruptions gracefully, allowing users to resume activities when the connection is restored.
7.	Project Gantt Chart
 

8.	References
1.	IEEE Std 830-1998, IEEE Recommended Practice for Software Requirements Specifications.
2.	COMSATS University Islamabad, "Final Year Project Guidelines," 2024.
3.	Sommerville, I. (2022). Software Engineering (11th ed.). Pearson Education Limited.
