# Chapter 8: Databases

---

### Chapter Overview

#### Topics
- Amazon Relational Database Service (Amazon RDS)
- Amazon DynamoDB
- Amazon Redshift
- Amazon Aurora


#### Lab
- Build Your DB Server and Interact with Your DB Using an App

---

## Chapter Objectives

After completing this chapter, you should be able to:
- Explain Amazon RDS and its core functionality
- Describe Amazon DynamoDB and its key features
- Understand Amazon Redshift and Amazon Aurora
- Launch, configure, and interact with an RDS database
- Differentiate between managed and unmanaged database services
- Choose the right AWS database solution for different scenarios

---

## Section 1: Amazon Relational Database Service (RDS)

### What is Amazon RDS?

- Managed relational database service (RDS) for SQL databases
- AWS handles scaling, fault tolerance, backups, patching, and high availability
- You focus on application optimization

#### Supported Engines

- Amazon Aurora
- PostgreSQL
- MySQL
- MariaDB
- Oracle
- Microsoft SQL Server

#### Key Features

- Database instance classes (CPU, memory, network)
- Storage options: Magnetic, General Purpose SSD, Provisioned IOPS
- High availability via Multi-AZ deployment (primary and standby in different AZs)
- Read replicas for scaling read-heavy workloads (asynchronous replication)
- Secure and scalable in a VPC, with subnets and security groups

#### Pricing & Deployment

- **Clock-hour billing:** Pay for running resources
- **Purchase types:** On-demand (pay by hour), Reserved Instances (discounts for commitment)
- **Storage:** Provisioned (included), backup storage (GB/month)
- **Deployment:** Single AZ or Multi-AZ, data transfer in is free, outbound is tiered

#### Use Cases

- Web/mobile apps: high throughput, scalable, high availability
- E-commerce: data security, low cost, managed solution
- Games: rapid scaling, automatic throughput, monitoring

#### When to Use RDS

- Need for complex transactions/queries, medium-high query rates, high durability
- Not ideal for massive throughput, sharding, or simple GET/PUT NoSQL

#### Key Takeaways

- RDS is a managed, scalable, highly available relational database
- Accessible via console, CLI, and API
- Supports several major database engines

---

## Section 2: Amazon DynamoDB

### Relational vs Non-Relational Databases

| Aspect           | Relational (SQL)               | Non-Relational (NoSQL)      |
|------------------|-------------------------------|-----------------------------|
| Data Storage     | Rows/columns                   | Key-value, document, graph  |
| Schemas          | Fixed                          | Dynamic                     |
| Querying         | SQL                            | Document/collection focus   |
| Scalability      | Vertical                       | Horizontal                  |

### What is DynamoDB?

- Fast, flexible, fully-managed NoSQL database
- Tables, items, and attributes (schema-less)
- Supports partition keys and sort keys
- SSD-backed, virtually unlimited storage
- Scalable read/write throughput, single-digit millisecond latency
- Automatic replication across chosen AWS Regions

#### Use Cases

- Mobile/web/gaming, adtech, IoT
- Accessible via console, CLI, API

#### Key Takeaways

- DynamoDB supports key-value and document models
- Scalable, low-latency, no limits on table size or throughput
- Fully managed, runs on SSDs

---

## Section 3: Amazon Redshift

### Overview

- Fully managed, fast, scalable data warehouse service for analytics and big data
- Columnar storage and parallel processing architecture
- Leader node and compute nodes (virtual cores, RAM, local disk)
- Integrates with SQL clients, BI tools, S3, DynamoDB

#### Features

- Automatic scaling and monitoring
- Built-in encryption
- No downtime for scaling

#### Use Cases

- Enterprise data warehouse, analytics, SaaS, big data
- Experimentation, migration from on-premises, manage as business grows

#### Key Takeaways

- Redshift is fast, scalable, and managed for big data analytics
- Supports columnar storage, parallel processing, automatic monitoring

---

## Section 4: Amazon Aurora

### Overview

- Enterprise-class relational database compatible with MySQL and PostgreSQL
- Automates provisioning, patching, backup, recovery, failure detection/repair
- Multiple levels of security

#### Features

- High performance, scalability, availability, durability
- Fully managed, easy migration

#### Key Takeaways

- Aurora offers high performance and availability, with compatibility for MySQL/PostgreSQL
- Fully managed, automated tasks, multiple security layers

---

## Section 5: Choosing the Right Database Tool

| Requirement                        | AWS Solution                   |
|-------------------------------------|--------------------------------|
| Enterprise-class relational DB      | Amazon RDS                    |
| Fast, flexible NoSQL                | Amazon DynamoDB               |
| OS/app features not supported by AWS| Databases on EC2              |
| Special cases (analytics, ML, graph)| Purpose-built AWS DB services  |

---

## Section 6: Database Case Studies

### Case 1: Data Protection/Management

- Needs: relational DB for config, unstructured store for metadata, S3 for storage, Glacier for archive
- Solutions: RDS/Aurora for config, DynamoDB for metadata

### Case 2: Shipping Company Migration

- Needs: move to serverless, legacy Oracle, structured/semistructured data
- Solutions: Aurora (PostgreSQL/MySQL), DynamoDB for semi-structured

### Case 3: Online Payment Processing

- Needs: high throughput for flash sales, millions of transactions/day, read replicas for scaling
- Solutions: RDS with read replicas, IAM and KMS for security

---

## Sample Exam Question

**Which of the following is a fully-managed NoSQL database service?**

| Choice | Response |
|--------|----------|
| A | Amazon Relational Database Service (Amazon RDS) |
| B | Amazon DynamoDB |
| C | Amazon Aurora |
| D | Amazon Redshift |

**Answer:**  
The correct answer is **B**.  
Keywords: "NoSQL database service".

---

## Resources

- [AWS Database page](https://aws.amazon.com/products/databases/)
- [Amazon RDS page](https://aws.amazon.com/rds/)
- [Overview of Amazon database services](https://docs.aws.amazon.com/whitepapers/latest/aws-overview/database.html)
- [Getting started with AWS databases](https://aws.amazon.com/products/databases/learn/)

---
