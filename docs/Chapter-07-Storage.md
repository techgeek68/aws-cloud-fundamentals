# Chapter 7: Storage

---

### Chapter Overview

#### Topics
- Amazon Elastic Block Store (Amazon EBS)
- Amazon Simple Storage Service (Amazon S3)
- Amazon Elastic File System (Amazon EFS)
- Amazon S3 Glacier

#### Lab
- Working with Amazon EBS

#### Activities
- Storage solution case study
---

## Chapter Objectives

After completing this chapter, you should be able to:
- Identify and differentiate AWS storage types: EBS, S3, EFS, S3 Glacier
- Explain the features and functionality of Amazon S3, EBS, EFS, and S3 Glacier
- Perform basic operations in Amazon EBS for EC2 storage solutions
- Choose appropriate storage solutions for different use cases

---

## Core AWS Storage Services

- **Amazon EBS:** Block storage for EC2
- **Amazon S3:** Object storage for virtually unlimited data
- **Amazon EFS:** Managed network file storage
- **Amazon S3 Glacier:** Low-cost, secure archiving

Other relevant core services: VPC, EC2, IAM, DynamoDB, RDS

---

## Section 1: Amazon Elastic Block Store (EBS)

### Overview

- Block-level storage volumes for EC2 instances
- Persistent, customizable, and replicated within its AZ
- Supports point-in-time snapshots (backed up to S3)
- Elasticity: change capacity and type

#### EBS Volume Types

| Type             | Max Size | Max IOPS | Max Throughput | Use Cases                                      |
|------------------|----------|----------|----------------|------------------------------------------------|
| General Purpose  | 16 TiB   | 16,000   | 250 MiB/s      | Most workloads, boot volumes, desktops         |
| Provisioned IOPS | 16 TiB   | 64,000   | 1,000 MiB/s    | Critical apps, large DBs, sustained IOPS       |
| Throughput-Opt.  | 16 TiB   | 500      | 500 MiB/s      | Streaming, log processing, big data            |
| Cold             | 16 TiB   | 250      | 250 MiB/s      | Low-cost, infrequent access, cannot be boot    |

#### EBS Features

- Snapshots for backup/recovery
- Encryption (no additional cost)
- Elastic volumes (resize/change type)
- Persistent independent of EC2 instance
- Charged by provisioned amount per month

#### Pricing

- Volumes: provisioned GB/month
- IOPS: SSD charged by GB, magnetic by requests
- Snapshots: charged by GB/month in S3
- Data transfer: inbound free, outbound cross-region charged

#### Key Takeaways

- Persistent block storage, choose SSD/HDD as needed
- Easy encryption, elastic volumes, snapshot backups

---

## Section 2: Amazon Simple Storage Service (S3)

### Overview

- Object storage, virtually unlimited
- Data stored as objects in buckets (max object size: 5 TB)
- Designed for 11 9s durability
- Granular access controls for buckets/objects

#### S3 Storage Classes

- Standard
- Intelligent-Tiering
- Standard-Infrequent Access (S3 Standard-IA)
- One Zone-Infrequent Access (S3 One Zone-IA)
- S3 Glacier
- S3 Glacier Deep Archive

#### S3 Bucket URLs

- Path-style: `https://s3.{region}.amazonaws.com/{bucket-name}`
- Virtual-hosted style: `https://{bucket-name}.s3-{region}.amazonaws.com`

#### Common Use Cases

- Application assets
- Static web hosting
- Backup/disaster recovery
- Big data staging

#### Pricing

- Pay for GB/month, requests, and outbound transfer
- No charge for inbound transfer or transfer to CloudFront/EC2 in the same region

#### Key Takeaways

- Fully managed, scalable object storage
- Access from anywhere via URL, rich security controls
- Pay only for what you use

---

## Section 3: Amazon Elastic File System (EFS)

### Overview

- Managed, scalable, elastic file storage
- Ideal for big data, analytics, media, content management, web serving, and home directories
- Petabyte-scale, low latency, supports NFSv4
- Shared storage, accessible from multiple EC2 instances

#### EFS Architecture

- File system with mount targets in each AZ subnet
- Network interfaces for NFS connectivity
- Security groups and tags for access and management

#### Implementation Steps

1. Create EC2 resources/instances
2. Create EFS file system
3. Create mount targets in the needed subnets
4. Connect EC2 to mount targets

#### Key Takeaways

- Provides managed network file storage, scales elastically, fully managed
- Accessible via console, CLI, API
- Pay only for what you use

---

## Section 4: Amazon S3 Glacier

### Overview

- Secure, durable, extremely low-cost data archiving
- Designed for 11 9s durability, encryption in transit and at rest
- Vault Lock for compliance

#### Retrieval Options

- Standard: 3–5 hours
- Bulk: 5–12 hours
- Expedited: 1–5 minutes

#### Use Cases

- Media, healthcare, compliance, scientific data, digital preservation, tape replacement

#### Lifecycle Policies

- Automatically move/delete objects based on age (e.g., archive after 30 days, delete after 5 years)

#### Security

- Server-side encryption (AES-256)
- IAM for access control

#### Key Takeaways

- S3 Glacier is best for long-term, infrequently accessed data
- Pricing is region-based, with very low cost
- 11 9s durability, secure by default

---

## Section 5: Storage Solution Case Studies

### Case 1: Analytics Company

- Billions of customer events per day, uses services like API Gateway, Kinesis, Lambda, ECS, Kinesis Data Firehose
- Storage solution: S3 for scalable object storage

### Case 2: Collaboration Software Company

- Petabytes of data for enterprise customers, uses EC2 and a corporate data center
- Storage solution: EFS or S3 for scalable, managed storage

### Case 3: Data Protection Company

- Ingest/store large amounts of customer data, compliance needs, uses EC2 and DynamoDB
- Storage solution: S3 Glacier for archiving, S3 for active storage

---

## Chapter Wrap-Up

### Summary

You now know how to:
- Identify and compare AWS storage types (EBS, S3, EFS, S3 Glacier)
- Explain the features/functionality of each service
- Build EC2 storage solutions with EBS
- Choose storage solutions for real-world scenarios

---

## Knowledge Check

---

## Sample Exam Question

**A company wants to store data that is not frequently accessed. What is the best and cost-effective solution that should be considered?**

| Choice | Response |
|--------|----------|
| A      | AWS Storage Gateway            |
| B      | Amazon Simple Storage Service Glacier |
| C      | Amazon Elastic Block Store (EBS)     |
| D      | Amazon Simple Storage Service (S3)   |

**Answer:**  
The correct answer is **B**.  
Keywords: "not frequently accessed" and "cost-effective solution."

---

## Resources

- [AWS Storage page](https://aws.amazon.com/products/storage/)
- [Storage Overview](https://docs.aws.amazon.com/whitepapers/latest/aws-overview/storage-services.html)
- [Recovering files from an Amazon EBS volume backup](https://aws.amazon.com/blogs/compute/recovering-files-from-an-amazon-ebs-volume-backup/)
- [Confused by AWS Storage Options? S3, EFS, EBS Explained](https://dzone.com/articles/confused-by-aws-storage-options-s3-ebs-amp-efs-explained)

---
