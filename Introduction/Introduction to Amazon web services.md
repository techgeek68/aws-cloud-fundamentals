
# Introduction to Amazon Web Services (AWS)

---

**What are Web Services?**
  - Software applications accessible over the internet, interoperable across platforms.
  - Use standardized formats (XML/JSON) for data exchange.
  - Operate through APIs (rules for software interaction).


**What is AWS?**
  - Secure cloud platform with global products.
  - On-demand access to compute, storage, network, database, and management tools.
  - Pay only for what you use; services work together like building blocks.


**Interacting with AWS**
  1. **AWS Management Console:** Graphical interface.
  2. **Command Line Interface (AWS CLI):** Commands or scripts.
  3. **Software Development Kits (SDKs):** Code integration (Java, Python, etc.).

---

**AWS Global Infrastructure**
- Designed for flexibility, reliability, scalability, and security.
  
  - **Global Infrastructure Map:** [AWS Global Infrastructure Map](https://aws.amazon.com/about-aws/global-infrastructure/#AWS_Global_Infrastructure_Map)
  
  - **Regions and Availability Zones:** [Regions & AZs](https://aws.amazon.com/about-aws/global-infrastructure/regions_az/)

**AWS Regions**
  - Geographical areas with AWS data centers.
  - Full redundancy and connectivity.
  - Each region has multiple Availability Zones (AZs).

**AWS Data Centers**
  - Secure, redundant power, networking, connectivity.
  - 50k-80k physical servers per center.

**Choosing an AWS Region**
  - Data governance/legal requirements
  - Proximity to customers (latency)
  - Service availability
  - Costs

**AWS Points of Presence (PoPs)**
  - **Edge Locations:** Serve cached content (CloudFront CDN)
  - **Regional Edge Caches:** For less frequently accessed content

---

**AWS Infrastructure Features**

- **Elasticity:** Dynamically adjusts capacity.
- **Scalability:** Grows with demand.
- **Fault-tolerance:** No single point of failure.
- **High availability:** Minimizes downtime.


**Regions vs Availability Zones vs Edge Locations**

| Type             | Description                                                                              |
|------------------|-----------------------------------------------------------------------------------------|
| Regions          | Virtual geographic areas with multiple availability zones. Geographic redundancy.        |
| Availability Zones | Separate clusters for fault tolerance and high availability. Host servers, apps, etc.   |
| Edge Locations   | Small data centers for caching and content delivery close to users.                     |


---

**AWS Services and Service Category**

**1. Application Services**
- Services directly consumed by end-users for specific tasks.
  *   **Amazon WorkSpaces:** Fully managed, secure Virtual Desktop Infrastructure (VDI).
  *   **Amazon Chime:** Unified communications service for online meetings, video conferencing, and business calling.

**2. Platform & Application Development Services**
- Managed building services, deploying, and managing applications without the heavy lifting of underlying infrastructure.

| Category | Key Services & Purpose |
| :--- | :--- |
| **Databases** | **RDS** (Managed Relational), **DynamoDB** (Managed NoSQL) |
| **Caching** | **ElastiCache** (In-memory data store for high-performance caching) |
| **Analytics** | **Redshift** (Cloud Data Warehousing), **Kinesis** (Real-time Data Streaming), **Glue** (Serverless ETL - Extract, Transform, Load) |
| **Application Integration** | **SQS** (Message Queuing), **Step Functions** (Workflow Orchestration), **SES** (Simple Email Service) |
| **End-User Computing** | **AppStream 2.0** (Secure Application Streaming) |
| **Media Services** | **MediaConvert** (File-based Video Transcoding) |
| **Deployment & Management** | **ECS/EKS** (Container Management), **CloudFormation** (Infrastructure as Code), **CodePipeline** (CI/CD Automation), **CloudWatch** (Monitoring & Observability) |
| **Mobile & Web** | **Cognito** (User Identity & Access Management), **Pinpoint** (User Engagement & Notifications) |

**3. Foundation Services (Core Compute, Storage & Networking)**
- The fundamental building blocks for any cloud workload.
  *   **Compute:**
      *   **EC2:** Scalable virtual servers.
      *   **Lambda:** Serverless functions (run code in response to events).
  *   **Storage:**
      *   **S3:** Highly durable and scalable object storage.
      *   **EBS:** High-performance block storage volumes for EC2.
      *   **Glacier/S3 Glacier:** Low-cost, long-term archive storage.
  *   **Networking & Content Delivery:**
      *   **VPC:** Isolated virtual network for your AWS resources.
      *   **Route 53:** Scalable and highly available Domain Name System (DNS).
      *   **CloudFront:** Global Content Delivery Network (CDN).

**4. Global Infrastructure**
- The physical foundation of the AWS cloud.
    *   **Regions:** Geographically separate locations (e.g., `us-east-1` - North Virginia).
    *   **Availability Zones (AZs):** One or more discrete data centers with redundant power, networking, and connectivity within a Region (e.g., multiple AZs in `us-east-1`).
    *   **Edge Locations:** Global sites used by **CloudFront** and **Route 53** to cache content and reduce latency for end-users.

---

**Introduction to Frameworks**

**Cloud Adoption Framework (CAF)**
  - Set of best practices/tools for cloud adoption.
  - Helps manage risks, costs, and compliance.
  - Optimizes governance/security.

**Perspective & Foundational Capabilities**

| Perspective | Capability Examples        |
|-------------|---------------------------|
| Security    | Infra protection, governance, incident response |
| Platform    | Architecture, engineering, CI/CD                |
| Governance  | Program management, financial mgmt, risk mgmt   |
| People      | Culture, workforce, leadership, org design       |


**Cloud Transformation Domain**

- Domains: Technology, Process, Organization, Product
- Capabilities: Business, People, Governance, Platform, Security, Operations
- Outcomes: Reduced risk, improved ESG, revenue growth, efficiency

**Cloud Transformation Journey**

**Phases:**
  1. **Envision:** Link cloud to business outcomes, prioritize opportunities.
  2. **Align:** Identify gaps, dependencies, stakeholder alignment.
  3. **Launch:** Pilot initiatives, learn & adjust.
  4. **Scale:** Expand pilots, associate business benefits with scaling.

---

**AWS Well-Architected Framework**
- Helps architects build secure, performant, resilient, and efficient infrastructure. Six pillars:
  1. **Security:** Protect data, systems, assets; compliance & risk management.
   - *Example:* Use CloudTrail for logging.
  2. **Operational Excellence:** Manage/monitor operations, improve processes.
   - *Example:* Use CodeCommit for version control.
  3. **Reliability:** Recover from failures, maintain performance.
   - *Example:* Multi-AZ RDS deployments.
  4. **Performance Efficiency:** Optimize resources, adapt to change.
   - *Example:* Use Lambda for serverless.
  5. **Cost Optimization:** Avoid unnecessary costs, maximize ROI.
   - *Example:* S3 Intelligent-Tiering.
  6. **Sustainability:** Environmentally responsible architecture.
   - *Example:* EC2 Auto Scaling.


**General Design Principles**
  - **Stop guessing capacity:** Scale automatically.
  - **Test at production scale:** Create test envs on demand.
  - **Automate:** Create/replicate workloads efficiently.
  - **Evolutionary architectures:** Design for change.
  - **Data-driven architecture:** Use data for improvement.
  - **Game days:** Simulate events to improve resilience.

---

**Sign up for AWS Account**

- Go to [AWS Sign Up](https://portal.aws.amazon.com/billing/signup)
- Follow the instructions.
- Create a root user, then assign admin access to another user.


**Create a User with Administrative Access**

1. Log in to AWS Management Console.
2. Turn on MFA.
3. Enable IAM Identity Center.
4. Add user, assign group, set permissions.


**Getting Started with the AWS Management Console**
  - **Features:** Service navigation, search, customization, notifications, cost/usage monitoring, favorites, CloudShell.
  - **Dashboard:** Widgets for health, cost, favorites, recent services, and Trusted Advisor.
  - **Navigation Bar:** Account info, region selector, service selector, search, CloudShell.

---
