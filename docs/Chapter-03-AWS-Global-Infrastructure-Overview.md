# Chapter 3: AWS Global Infrastructure Overview

---

### Chapter Overview

#### Topics
- AWS Global Infrastructure
- AWS Services and Service Categories

---

## Section 1: AWS Global Infrastructure

### What is AWS Global Infrastructure?

The AWS Global Infrastructure is designed to be flexible, reliable, scalable, and secure, providing high-quality global network performance. AWS continually updates its global footprint. You can check the latest info at:
- [AWS Global Infrastructure Map](https://aws.amazon.com/about-aws/global-infrastructure/#AWS_Global_Infrastructure_Map)
- [Regions and Availability Zones](https://aws.amazon.com/about-aws/global-infrastructure/regions_az/)

#### AWS Regions

- An AWS Region is a distinct geographic area.
- Regions are isolated from each other, and data replication is controlled by you.
- Communication between Regions uses AWS’s backbone network.
- Each Region is made up of multiple Availability Zones.

##### Factors for Selecting a Region

- Data governance & legal requirements
- Proximity to customers (latency)
- Services available within the Region
- Cost (may vary by Region)

#### Availability Zones

- Each Region contains multiple Availability Zones (AZs).
- AZs are isolated partitions with discrete data centers, designed for fault isolation.
- AZs are connected with high-speed networking.
- You can choose which AZs to use; AWS recommends replicating resources across AZs for resiliency.

#### AWS Data Centers

- Built for security and reliability
- Redundant power, networking, and connectivity
- Each data center typically has 50,000 to 80,000 physical servers

#### Points of Presence

- AWS operates a global network of Points of Presence (PoPs)
- Includes Edge Locations and Regional Edge Caches
- Used by Amazon CloudFront (CDN) for low-latency content delivery

#### Key Infrastructure Features

- **Elasticity and Scalability:** Can dynamically adapt capacity and grow as needed
- **Fault-tolerance:** Built-in redundancy, continues operating during failures
- **High Availability:** Minimized downtime, high operational performance

---

### Regions vs Availability Zones vs Edge Locations

- **Regions:** Geographic areas containing multiple AZs; support compliance and redundancy
- **Availability Zones:** Separate data center clusters for fault tolerance and high availability
- **Edge Locations:** Small data centers for web content and caching, improving content delivery

#### Key Takeaways

- AWS Global Infrastructure consists of Regions and AZs
- Region choice driven by compliance and latency
- AZs are physically separate with redundant power and connectivity
- Edge Locations and caches improve user experience by caching content closer to users

---

## Section 2: AWS Services and Service Categories

### AWS Foundational Services

Some of the fundamentals covered:
- Applications, virtual desktops, collaboration
- Databases, analytics, application services
- Containers, orchestration, DevOps tools
- Compute, networking, storage

### AWS Service Categories

- Analytics
- Application Integration
- AR & VR
- Blockchain
- Cost Management
- Customer Engagement
- Database
- Developer Tools
- Business Applications
- End User Computing
- IoT
- Machine Learning
- Robotics
- Management & Governance
- Media Services
- Migration & Transfer
- Networking & Content Delivery
- Security, Identity, & Compliance
- Satellite
- Storage
- Compute
- Game Tech
- Mobile

#### Storage Services

- **Amazon S3:** Object storage, buckets, archival, backup, disaster recovery.  
  Pricing: $0.023/GB (first 50TB), $0.022/GB (next 450TB), $0.021/GB (over 500TB)
- **Amazon EBS:** Block storage, volumes from 10GB to 1TB  
  Pricing: $0.125/GB/month, $0.10 per provisioned IOPS/month
- **Amazon EFS:** File storage for web, content management, backups, analytics  
  Pricing (IA): $0.025/GB/month + $0.01/GiB-transferred
- **Amazon S3 Glacier:** Archival storage  
  Pricing: Free for first 1GB/month, $0.05–$0.09/GB/month depending on volume

#### Compute Services

- Amazon EC2, Auto Scaling, ECS, ECR, Elastic Beanstalk, Lambda, EKS, Fargate

#### Database Services

- Amazon RDS, Aurora, Redshift, DynamoDB

#### Networking & Content Delivery

- Amazon VPC, Elastic Load Balancing, CloudFront, Transit Gateway, Route 53, Direct Connect, VPN

#### Security, Identity, & Compliance

- AWS IAM, Organizations, Cognito, Artifact, KMS, Shield

#### Cost Management

- Cost and Usage Report, Budgets, Cost Explorer

#### Management & Governance

- Management Console, Config, CloudWatch, Auto Scaling, CLI, Trusted Advisor, Well-Architected Tool, CloudTrail

---

## Hands-on Activity: AWS Management Console Clickthrough

1. Launch the AWS Management Console (Sandbox environment).
2. Explore the Services menu; notice how services are grouped into categories.
   - Example: EC2 is under Compute.
3. Answer the following:
   - **Q1:** Under which category is IAM?  
     **A:** Security, Identity & Compliance
   - **Q2:** Under which category is Amazon VPC?  
     **A:** Networking & Content Delivery
   - **Q3:** Does a subnet exist at the Region or AZ level?  
     **A:** Availability Zone level
   - **Q4:** Does a VPC exist at the Region or AZ level?  
     **A:** Region level
   - **Q5:** Which services are global (not regional)? (Check EC2, IAM, Lambda, Route 53)  
     **A:** IAM and Route 53 are global; EC2 and Lambda are regional.

---

## Sample Exam Question

**Which component of AWS global infrastructure does Amazon CloudFront use to ensure low-latency delivery?**

| Choice | Response |
|--------|----------|
| A | AWS Regions |
| B | AWS Edge Locations |
| C | AWS Availability Zones |
| D | Amazon VPC |

**Answer:**  
The correct answer is **B**.  
The keywords to note: AWS global infrastructure, CloudFront, low-latency.

---

## Resources

- [AWS Global Infrastructure](https://aws.amazon.com/about-aws/global-infrastructure/)
- [AWS Regional Services List](https://aws.amazon.com/about-aws/global-infrastructure/regional-product-services/)
- [AWS Cloud Products](https://aws.amazon.com/products/)

---
