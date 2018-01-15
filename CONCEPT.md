# Free PMO

Free PMO is a tool simplify project management and monitoring for freelancers and agencies, or any company that has project-based services for their customers.

## Concepts

These are feature list that already or will be implemented on Free PMO application. This application runs by our agency, so **agency** terms in this document means **us** (freelancer, agency, or company who runs the business).

### 1. User and Roles

Free PMO has two types of user :

1. **Administrator** (control all system data)
2. **Worker** (worker that will be assigned to project jobs and paid on each project)

Most likely more user roles will be implemented in the future.

### 2. Project

Projects are jobs managed by agency for their customers.

1. A **project** belongs to one **Customer**
2. A **project** has many **Jobs** (Job items)
3. A **project** has many **Invoices**
4. A **project** has many **Payments** (with or without invoice)
5. A **project** has many **Meetings** (with customer, TODO)
6. A **project** has many **Subscriptions** (eg. domains, hostings, maintenance services)
7. A **project** has many **Files** Dokumen (TODO)

#### Model Relatons

1. **Project** belongs to a **Customer**; Customer has 0 to many Projects
2. **Project** has 0 to many **Jobs**/Project Items; Job belongs to a Project
3. **Project** has 0 to many **Invoices**; Invoice belongs to a Project
4. **Project** has 0 to many **Payments**; Payment belongs to a Project
5. **Project** has 0 to many **Meetings**; Meeting belongs to a Project
6. **Project** has 0 to many **Subscriptions**; Subscription belongs to a Project
7. **Project** has 0 to many **Files**; File belongs to a Project

### 3. Job

1. **Job** has price/cost (eg. for worker payments).
2. **Job** has one **User** sebagai as worker or person in-charge.
3. **Job** has many **Tasks** (just like job progress checklist).
4. **Job** has these attributes :
    - Job name
    - Description
    - PIC (worker/person in-charge)
    - Cost/Fee
    - Priority
    - start date (TODO)
    - end date (TODO)
    - cancel date (TODO).
5. **Job** has many dependencies to other jobs (TODO), Eg. Job A is dependency of job B, then job A must be finished before Job B is starting.
6. Job progress is calculated based on the average progress of the task (in %).
7. **Job** list can be prioritized.

### 4. Task

Tasks are job items that must be monitor by Job PICs or done by job worker.

1. **Task** belongs to a **Job**
2. **Task** can be prioritized
3. **Task** has these attributes :
    - Task name
    - Description
    - Progress (0 - 100 %)
    - Priority

### 5. Payment

Payments are any payment transactions by customer to agency (as income), or from agency to vendor (outcome), or from agency to worker/user (outcome).

1. A **Project** has many **Payments**
2. **Payment** belongs to a **Project**
3. **Payment** belongs to an **Invoice** (TODO)
4. **Payment** can be printed out as **Receipt**
5. **Payment** belongs to a partner : Vendor or Customer or User (Polymorphic Relations)

### 6. Vendor

Vendors are suppliers or providers that provides services for our agency. Agency will pay Vendors as outcome payment/transaction.

1. **Vendor** has many **Payments**.

### 7. Subscription

Subscriptions are any services that being used by customer's project, subscriptions are paid regularly by customer. This feature main purpose is to remind us for our customer/client's regular payment.

1. **Subscription** belongs to a **Project**
2. **Subscription** belongs to a **Customer**
3. **Subscription** belongs to a **Vendor**

### 7. Earning reports

Earning reports are agency outcome and income transaction summary.

#### Yearly Report

Yearly report consist of profit graph and income-outcome summary table based on monthly transaction summary. We can select year to filter transaction by selected year. Current year is default. We can also see monthly report from this yearly report page.

#### Monthly Report

Monthly report consist of profit graph and income-outcome summary table based on daily transaction summary. We can select month and year to filter transaction by selected year-month. Current month is default. We can also see daily report from this monthly report page.

#### Daily Report

Daily report is list of payments or transactions that happens on selected date. We can select date to see transaction list on selected date. Today is default.

### 8. Receiveable Earnings Report

This report contains list of project with customer's payments that we will be received if project has been completed.

### 9. Admin Dashboard

Agency Administrator's Dashboard consists of :

1. List of project status based on current project stat.
2. Earning stat :
    - Current year total earnings
    - Current year completed projects count
    - Receiveable earnings summary
3. List of customer's subscriptions that will expire within next 60 days.

### 10. Invoice

Invoices are customer's payments bill.

1. **Invoice** belongs to a **Project**
2. **Invoice** has many **Payments** (eg. the invoice is paid in installments) (TODO)
3. **Invoice** status can be updated as "Paid" (TODO)
4. **Invoice** has attributes :
    - Invoice Number
    - Project
    - Date
    - Due date
    - Invoice items
    - Invoice (billed) Amount
    - Notes
    - Status
    - Invoice creator (user)

### 11. Meeting (TODO)

Meetings are any meeting or discussion between us (the agency) with our customer based on project.

1. **Meeting** belongs to a **Project**
2. **Meeting** can be printed out as Minutes of Meeting (MoM)
3. BAP has attributes :
    - Date
    - Project
    - List of attendees
    - Meeting agenda
    - Meeting results
    - Notes
