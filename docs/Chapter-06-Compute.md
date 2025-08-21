# Chapter 6: Compute

---

### Chapter Overview

#### Topics
- Overview of AWS compute services
- Amazon EC2
- EC2 cost optimization
- Container services (ECS, EKS, ECR, Fargate)
- AWS Lambda introduction
- AWS Elastic Beanstalk introduction

#### Activities
- Compare EC2 and managed services
- Hands-on with AWS Lambda
- Hands-on with AWS Elastic Beanstalk

#### Lab
- Introduction to Amazon EC2

---

## Chapter Objectives

By the end of this chapter, you will be able to:
- Summarize the main AWS compute services
- Explain the use cases for Amazon EC2
- Navigate EC2 console functionality and build a virtual environment
- Identify cost optimization strategies for EC2
- Determine when to use Elastic Beanstalk and Lambda
- Run containerized apps in managed clusters

---

## Section 1: AWS Compute Services Overview

### Key Services

- **Amazon EC2** (virtual machines)
- **Amazon EC2 Auto Scaling**
- **Amazon Elastic Container Registry (ECR)**
- **Amazon Elastic Container Service (ECS)**
- **VMware Cloud on AWS**
- **AWS Elastic Beanstalk**
- **AWS Lambda** (serverless)
- **Amazon Elastic Kubernetes Service (EKS)**
- **Amazon Lightsail**
- **AWS Batch**
- **AWS Fargate**
- **AWS Outposts**
- **AWS Serverless Application Repository**

#### Categorizing Compute Services

| Service        | Key Concepts              | Characteristics                 | Ease of Use            |
|----------------|--------------------------|----------------------------------|------------------------|
| EC2            | IaaS, VM, full control    | Familiar for IT professionals    | Flexible, customizable |
| Lambda         | Serverless, event-based   | Low cost, no server management  | Easy to learn/use      |
| ECS/EKS/Fargate| Container orchestration   | Instance-based, scalable        | Fargate automates infra|
| Elastic Beanstalk| PaaS, web apps          | Focus on code, simple deployment| Quick start, easy tie-in|

#### Choosing the Right Compute Service

Consider:
- Application design
- Usage patterns
- Control/configuration needs
- Performance efficiency

---

## Section 2: Amazon EC2

### What is Amazon EC2?

- Provides virtual machines ("EC2 instances") in the AWS Cloud
- Full control over the OS (Windows/Linux)
- Launch instances in any AZ, from AMIs
- Manage security, networking, and scaling

#### Launching an EC2 Instance: 9 Key Decisions

1. **Select an AMI:** 
   - Prebuilt (Quick Start), custom, Marketplace, Community
   - AMIs are templates for EC2 instances, can be copied between regions
2. **Select Instance Type:** 
   - Memory, CPU, storage, network performance
   - Categories: General Purpose, Compute Optimized, Memory Optimized, Storage Optimized, Accelerated Computing
   - Naming (e.g., t3.large): family, generation, size
3. **Specify Network Settings:**
   - VPC/subnet, public IP assignment
4. **Attach IAM Role (optional):**
   - Needed if instance accesses other AWS services
5. **User Data Script (optional):**
   - Bootstrap environment, automate setup
6. **Specify Storage:**
   - Root volume (OS), additional volumes, EBS or Instance Store, encryption
7. **Add Tags:**
   - Key-value metadata for filtering, automation, cost allocation
8. **Security Group Settings:**
   - Firewall rules for allowed ports, protocols, sources
9. **Key Pair:**
   - For secure login (SSH for Linux, password for Windows)

### EC2 Storage Options

- **Amazon EBS:** Durable block storage, persists after stop/start
- **Instance Store:** Ephemeral, tied to host (data lost on stop)
- **Amazon EFS/S3:** For additional storage

### Instance Lifecycle

- States: pending, running, stopping, stopped, rebooting, terminated
- Only EBS-backed instances can be stopped

### Elastic IP Addresses

- Persistent public IPs, can be remapped, remain allocated until released

### EC2 Metadata

- Access via `http://169.254.169.254/latest/meta-data/`
- Includes instance ID, IPs, hostnames, security groups, region, AZ, user data

### Monitoring with CloudWatch

- Basic monitoring (5 min intervals, free), detailed (1 min, paid)
- View metrics/history in EC2 console

---

## Section 3: EC2 Cost Optimization

### EC2 Pricing Models

- **On-Demand:** Pay by hour, no commitment
- **Reserved:** Discount, commitment (1/3 years, upfront/partial/no upfront)
- **Spot:** Bid for unused capacity, can be interrupted, big savings
- **Dedicated Hosts/Instances:** Physical isolation, licensing, compliance
- **Scheduled Reserved:** Recurring capacity reservation

#### Use Cases

- On-Demand: Spiky, unpredictable workloads
- Reserved: Steady state, predictable usage
- Spot: Flexible, time-insensitive workloads
- Dedicated: Compliance, dedicated hardware

#### Four Pillars of Cost Optimization

1. **Right Size:** Match instance type to workload, use CloudWatch to downsize
2. **Increase Elasticity:** Stop/hibernate unused instances, use Auto Scaling
3. **Optimal Pricing Model:** Mix On-Demand, Spot, Reserved; consider serverless
4. **Optimize Storage Choices:** Resize/change EBS types, delete old snapshots, use S3 lifecycle policies

#### Ongoing Optimization

- Tagging for cost allocation
- Define metrics and targets
- Review regularly and assign responsibility

---

## Section 4: Container Services

### Containers 101

- OS virtualization, repeatable/self-contained environments
- Fast to launch/stop, consistent across environments

### Docker

- Platform for building/running containers
- Containers created from images contain everything needed to run

#### Containers vs VMs

- Multiple containers on one EC2 instance
- Each VM requires a separate OS/EC2 instance

### Amazon ECS (Elastic Container Service)

- Managed container orchestration for Docker
- Integrates with EC2 features (security groups, EBS, IAM)

#### ECS Cluster Options

- **EC2-backed:** You manage infrastructure
- **Fargate-backed:** AWS manages infrastructure

### Kubernetes & Amazon EKS

- Kubernetes: Open source container orchestration
- EKS: Managed Kubernetes on AWS, supports Linux/Windows, integrates with EC2

### Amazon ECR

- Fully managed Docker container registry, supports team collaboration, access control, and integrations

---

## Section 5: AWS Lambda

### What is AWS Lambda?

- Serverless compute, run code in response to events/schedule
- No server management, pay only for compute time used

#### Benefits

- Multiple languages, automated admin, fault tolerance, orchestration, pay-per-use

#### Event Sources

- S3, DynamoDB, SNS, SQS, API Gateway, CloudWatch, custom triggers

#### Function Configuration

- Code, dependencies, IAM role, monitoring/logging

#### Example Use Cases

- Schedule-based: Start/stop EC2
- Event-based: Image processing (e.g., S3 uploads trigger thumbnail creation)

#### Lambda Quotas

- 1,000 concurrent executions/region
- 75 GB function/layer storage
- 10,240 MB max memory
- 15 min max runtime
- 250 MB deployment package, 10 GB container image

---

## Section 6: AWS Elastic Beanstalk

### What is Elastic Beanstalk?

- Managed service to deploy web applications
- Handles provisioning, deployment, scaling, load balancing, health monitoring, and debugging

#### Supported Languages

- Java, .NET, PHP, Node.js, Python, Ruby, Go, Docker

#### Benefits

- Fast/simple to start, boosts productivity, offers complete resource control, no extra cost (only pay for resources used)

---

## Chapter Wrap-Up

### Summary

You now know how to:
- Overview of AWS compute services
- Use Amazon EC2 and optimize for cost
- Work with container services (ECS, EKS, ECR, Fargate)
- Build and deploy with AWS Lambda and Elastic Beanstalk

---

## Knowledge Check

---

## Sample Exam Question

**Which AWS service helps developers quickly deploy resources that can make use of different programming languages, such as .NET and Java?**

| Choice | Response |
|--------|----------|
| A | AWS CloudFormation |
| B | AWS SQS |
| C | AWS Elastic Beanstalk |
| D | Amazon Elastic Compute Cloud (Amazon EC2) |

**Answer:**  
The correct answer is **C**.  
Keywords: developers, quickly deploy resources, and different programming languages.

---

## Resources

- [Amazon EC2 Documentation](https://docs.aws.amazon.com/ec2/)
- [Amazon EC2 Pricing](https://aws.amazon.com/ec2/pricing/)
- [Amazon ECS Workshop](https://ecsworkshop.com/)
- [Running Containers on AWS](https://containersonaws.com/)
- [Amazon EKS Workshop](https://www.eksworkshop.com/)
- [AWS Lambda Documentation](https://docs.aws.amazon.com/lambda/)
- [AWS Elastic Beanstalk Documentation](https://docs.aws.amazon.com/elastic-beanstalk/)
- [Cost Optimization Playbook](https://d1.awsstatic.com/pricing/AWS_CO_Playbook_Final.pdf)

---
