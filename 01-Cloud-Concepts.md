# Chapter 1: Cloud Concepts

---

### Chapter overview

#### Topics
- Introduction to cloud computing
- Advantages of cloud computing
- Introduction to Amazon Web Services (AWS)
- AWS Cloud Adoption Framework (AWS CAF)

---

## Section 1: Introduction to Cloud Computing

### What is cloud computing?

#### Cloud computing defined
Cloud computing is the on-demand delivery of computing power, database, storage, applications, and other IT resources via the internet with pay-as-you-go pricing.

#### Infrastructure as software
Cloud computing enables you to stop thinking of your infrastructure as hardware, and instead think of (and use) it as software.

#### Traditional computing model
- Infrastructure as hardware
- Hardware solutions:
  - Require space, staff, physical security, planning, and capital expenditure
  - Have a long hardware procurement cycle
  - Require you to provision capacity by guessing theoretical maximum peaks

#### Cloud computing model
- Infrastructure as software
- Software solutions:
  - Are flexible
  - Can change more quickly, easily, and cost-effectively than hardware solutions
  - Eliminate the undifferentiated heavy-lifting tasks

#### Cloud service models
| Model | Name | Control over IT resources |
|-------|------|--------------------------|
| IaaS  | Infrastructure as a Service | More control |
| PaaS  | Platform as a Service      | Moderate control |
| SaaS  | Software as a Service      | Less control |

#### Cloud computing deployment models
- Cloud
- Hybrid
- On-premises (private cloud)

#### Similarities between AWS and traditional IT

| Traditional IT        | AWS Equivalent         |
|----------------------|-----------------------|
| Security             | Security groups, Firewalls, ACLs, Administrators, Network ACLs, IAM |
| Networking           | Router, Network pipeline, Switch, Elastic Load Balancing, Amazon VPC |
| Compute servers      | AMI, Amazon EC2 instances |
| Storage and database | DAS, SAN, NAS, RDBMS, Amazon EBS, Amazon EFS, Amazon S3, Amazon RDS |

---

## Section 2: Advantages of Cloud Computing

### Trade capital expense for variable expense
- Data center investment based on forecast vs. pay only for the amount you consume

### Massive economies of scale
- AWS aggregates usage from all customers, achieving higher economies of scale and passing savings to customers.

### Stop guessing capacity
- Scale on demand instead of overestimating or underestimating server capacity.

### Increase speed and agility
- Minutes between wanting resources and having resources (not weeks).

### Stop spending money on running and maintaining data centers
- Focus investment on business and customers, not infrastructure.

### Go global in minutes

---

## Section 3: Introduction to Amazon Web Services (AWS)

### What are web services?
A web service is any piece of software that makes itself available over the internet and uses a standardized format—such as XML or JSON—for API requests and responses.

#### What is AWS?
- Secure cloud platform offering a broad set of global cloud-based products
- On-demand access to compute, storage, network, database, and other IT resources and management tools
- Flexibility: pay only for the services you use
- Services work together like building blocks

#### Categories of AWS services
- Analytics
- Application Integration
- AR and VR
- Blockchain
- Cost Management
- Customer Engagement
- Database
- Developer Tools
- Internet of Things
- Machine Learning
- Management and Governance
- Media Services
- Networking and Content Delivery
- Robotics
- Satellite
- Security, Identity, and Compliance
- Business Applications
- End User Computing
- Migration and Transfer
- Storage
- Compute
- Game Tech
- Mobile

#### Simple solution example
- Networking: Virtual Private Cloud (VPC)
- Database: Amazon DynamoDB
- Compute: Amazon EC2
- Storage: Amazon S3
- Users access via AWS Cloud

#### Choosing a service
The service you select depends on your business goals and technology requirements.

#### Services covered in this course

**Compute services:**
- Amazon EC2
- AWS Lambda
- AWS Elastic Beanstalk
- Amazon EC2 Auto Scaling
- Amazon ECS
- Amazon EKS
- Amazon ECR
- AWS Fargate

**Storage services:**
- Amazon S3
- Amazon S3 Glacier
- Amazon EFS
- Amazon EBS

**Database services:**
- Amazon RDS
- Amazon DynamoDB
- Amazon Redshift
- Amazon Aurora

**Management and Governance services:**
- AWS Trusted Advisor
- AWS CloudWatch
- AWS CloudTrail
- AWS Well-Architected Tool
- AWS Auto Scaling
- AWS Command Line Interface
- AWS Config
- AWS Management Console
- AWS Organizations

**Security, Identity, and Compliance services:**
- AWS IAM
- Amazon Cognito
- AWS Shield
- AWS Artifact
- AWS KMS

**Networking and Content Delivery services:**
- Amazon VPC
- Amazon Route 53
- Amazon CloudFront
- Elastic Load Balancing

**AWS Cost Management services:**
- AWS Cost & Usage Report
- AWS Budgets
- AWS Cost Explorer

#### Three ways to interact with AWS
- **AWS Management Console:** Easy-to-use graphical interface
- **Command Line Interface (AWS CLI):** Access services by discrete commands or scripts
- **Software Development Kits (SDKs):** Access services directly from your code (e.g., Java, Python, etc.)

---

## Section 4: Moving to the AWS Cloud – The AWS Cloud Adoption Framework (AWS CAF)

### AWS Cloud Adoption Framework (AWS CAF)

#### AWS CAF perspectives
- Provides guidance and best practices for a comprehensive approach to cloud computing across the organization and IT lifecycle
- Organized into six perspectives, each with sets of capabilities

#### Six core perspectives
- Focus on business capabilities
- Focus on technical capabilities

#### Perspective details

**Business perspective**
- Align IT with business needs; trace IT investments to business results
- Capabilities: IT finance, IT strategy, benefits realization, business risk management
- Stakeholders: Business managers, finance managers, budget owners, strategy stakeholders

**People perspective**
- Prioritize training, staffing, and organizational changes for agility
- Capabilities: Resource management, incentive management, career management, training management, organizational change management
- Stakeholders: Human resources, staffing, people managers

**Governance perspective**
- Align IT strategy and goals with business strategy and goals; maximize business value, minimize risk
- Capabilities: Portfolio management, program/project management, business performance measurement, license management
- Stakeholders: CIO, program managers, enterprise architects, business analysts, portfolio managers

**Platform perspective**
- Understand and communicate IT systems and their relationships; describe target architecture
- Capabilities: Compute, network, storage, database provisioning, systems and solution architecture, application development
- Stakeholders: CTO, IT managers, solutions architects

**Security perspective**
- Ensure organization meets security objectives
- Capabilities: Identity/access management, detective control, infrastructure security, data protection, incident response
- Stakeholders: CISO, IT security managers, analysts

**Operations perspective**
- Align with/support business operations; define day-to-day and long-term operations
- Capabilities: Service monitoring, application performance monitoring, resource inventory, release/change management, reporting/analytics, business continuity/disaster recovery, IT service catalog
- Stakeholders: IT operations managers, IT support managers

---

## Sample Exam Question

**Why is AWS more economical than traditional data centers for applications with varying compute workloads?**

| Choice | Response |
|--------|----------|
| A | Amazon EC2 costs are billed on a monthly basis. |
| B | Customers retain full administrative access to their Amazon EC2 instances. |
| C | Amazon EC2 instances can be launched on demand when needed. |
| D | Customers can permanently run enough instances to handle peak workloads. |

**Answer:**  
The correct answer is **C**.  
The keywords in the question are "AWS is more economical than traditional data centers for applications with varying workloads".

---

## Resources

- [What is AWS? (YouTube)](https://www.youtube.com/watch?v=mZ5H8sn_2ZI&feature=youtu.be)
- [Cloud computing with AWS website](https://aws.amazon.com/what-is-aws/)
- [Overview of Amazon Web Services whitepaper](https://d1.awsstatic.com/whitepapers/aws-overview.pdf)
- [An Overview of the AWS Cloud Adoption Framework whitepaper](https://d1.awsstatic.com/whitepapers/aws_cloud_adoption_framework.pdf)
- [6 Strategies for Migrating Applications to the Cloud (AWS Cloud Enterprise Strategy blog)](https://aws.amazon.com/blogs/enterprise-strategy/6-strategies-for-migrating-applications-to-the-cloud/)

---
