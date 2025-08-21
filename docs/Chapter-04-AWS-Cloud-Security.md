# Chapter 4: AWS Cloud Security

---

### Chapter Overview

#### Topics
- AWS Shared Responsibility Model
- AWS Identity and Access Management (IAM)
- Securing a new AWS account
- Securing accounts and data
- Ensuring compliance
---

## Chapter Objectives

After finishing this chapter, you should be able to:
- Recognize the AWS shared responsibility model
- Identify the responsibilities of AWS vs. the customer
- Understand IAM users, groups, and roles
- Describe security credentials in IAM
- List steps to secure a new AWS account
- Secure AWS data and accounts
- Recognize AWS compliance programs

---

## Section 1: AWS Shared Responsibility Model

### Overview

AWS security is a shared responsibility between AWS and the customer:
- **AWS's responsibility:** Security _of_ the cloud (physical security, infrastructure, hardware, software, networking, facilities)
- **Customer's responsibility:** Security _in_ the cloud (data, applications, OS, network/firewall config, IAM, encryption, account management)

#### Examples

**Customer-managed services (IaaS):**
- EC2, EBS, VPC
- More flexibility, but more security responsibility

**AWS-managed services (PaaS/SaaS):**
- Lambda, RDS, Elastic Beanstalk, Trusted Advisor, Shield, Chime
- AWS handles infrastructure, patching, firewalls, disaster recovery

#### Shared Responsibility Scenarios

**Scenario 1:**
- OS upgrades on EC2? **Customer**
- Physical data center security? **AWS**
- EC2 security group settings? **Customer**
- Oracle upgrades (on RDS)? **AWS**
- S3 bucket access config? **Customer**

**Scenario 2:**
- AWS Console not hacked? **AWS**
- Configuring subnet/VPC? **Customer**
- Securing SSH keys? **Customer**
- Network isolation between customers? **AWS**
- Enforcing MFA logins? **Customer**

#### Key Takeaways

- AWS: Security _of_ the cloud
- Customer: Security _in_ the cloud
- For IaaS, customer manages security config (guest OS, patches, firewalls)
- For SaaS, AWS manages most underlying security tasks

---

## Section 2: AWS Identity and Access Management (IAM)

### IAM Overview

- IAM helps you manage access to AWS resources.
- You define _who_ can access _what_ and _how_.
- IAM is a free AWS account feature.

#### IAM Components

- **IAM User:** Person or application with credentials
- **IAM Group:** Collection of users sharing permissions
- **IAM Policy:** JSON document defining permissions (identity-based or resource-based)
- **IAM Role:** Assumable identity for temporary access; not tied to a specific person

#### Authentication

- **Programmatic access:** Access key ID + secret access key (CLI, SDK)
- **Console access:** Account ID/alias, username, password, MFA (if enabled)

#### Authorization

- Permissions are assigned using IAM policies
- Principle of least privilege: grant only what is needed
- IAM settings are global (apply across all regions)

#### IAM Policy Types

- **Identity-based:** Attached to a user, group, or role
- **Resource-based:** Attached directly to a resource (e.g., S3 bucket)

#### Example IAM Policy

```json
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": ["DynamoDB:*", "s3:*"],
      "Resource": [
        "arn:aws:dynamodb:region:account:table/table-name",
        "arn:aws:s3:::bucket-name",
        "arn:aws:s3:::bucket-name/*"
      ]
    },
    {
      "Effect": "Deny",
      "Action": ["dynamodb:*", "s3:*"],
      "NotResource": [
        "arn:aws:dynamodb:region:account:table/table-name",
        "arn:aws:s3:::bucket-name",
        "arn:aws:s3:::bucket-name/*"
      ]
    }
  ]
}
```

- Explicit deny always overrides allow.

#### IAM Groups and Roles

- Groups: Assign same permissions to multiple users (users can belong to multiple groups)
- Roles: Used for delegating access (temporary credentials), can be assumed by users, services, or apps

---

## Section 3: Securing a New AWS Account

### Best Practices

- Don’t use the root user except when absolutely necessary
- Create an IAM user for yourself, add to an admin group, and disable root access keys
- Enable a password policy
- Enable MFA for root and IAM users
- Use AWS CloudTrail for activity tracking (free for last 90 days)
- Enable billing reports (Cost & Usage Report to S3 bucket)

#### Steps

1. Create IAM users and groups (admin group for yourself)
2. Enable password policy and remove root access keys
3. Enable MFA (virtual/hardware options)
4. Set up CloudTrail and configure logging (store logs in S3)
5. Enable billing reports

#### Key Takeaways

- Use MFA for all logins
- Delete root user access keys
- Grant permissions according to least privilege
- Assign permissions via groups and roles (never share credentials)
- Monitor activity with CloudTrail

---

## Lab: Introduction to IAM

**Tasks:**
- Explore users and groups
- Add users to groups
- Sign in and test user access

**Example Final Setup:**
- 
- 
- 

---

## Section 4: Securing Accounts

### AWS Organizations

- Centrally manage multiple AWS accounts
- Organize accounts into OUs and apply access policies
- Use Service Control Policies (SCPs) for centralized permission limits (SCPs set max permissions — never grant, only restrict)
- SCPs intersect with IAM permissions (final permissions = both IAM and SCP allow)

### Security Services

- **AWS Key Management Service (KMS):** Manage encryption keys, control encryption use, integrates with CloudTrail, uses HSMs
- **Amazon Cognito:** User sign-up, sign-in, access control for web/mobile apps, supports social and enterprise identities
- **AWS Shield:** DDoS protection (Standard is free; Advanced is paid), always-on detection, automatic mitigation

---

## Section 5: Securing Data on AWS

### Encryption

- **Data at rest:** Encrypt stored data (S3, EBS, EFS, RDS) using AWS KMS
- **Data in transit:** Use TLS/SSL to encrypt data moving across networks; AWS Certificate Manager manages certificates

### Securing S3 Buckets and Objects

- S3 buckets/objects are private by default
- Use Block Public Access, IAM policies, bucket policies, ACLs, and Trusted Advisor for permissions
- Always follow least privilege

---

## Section 6: Working to Ensure Compliance

### AWS Compliance Programs

- AWS works with certifying bodies and auditors to provide compliance info
- Categories: Certifications (ISO, SOC, PCI), Laws/Regulations (GDPR, HIPAA), Frameworks (CIS, Privacy Shield)
- **AWS Config:** Assess, audit, and monitor resource configurations; simplifies compliance audits
- **AWS Artifact:** Access compliance reports and agreements directly from the AWS Console

#### Key Takeaways

- AWS provides info about security policies, controls, and compliance programs
- AWS Config for configuration auditing
- AWS Artifact for security/compliance reports

---

## Sample Exam Question

**Which of the following is AWS's responsibility under the AWS shared responsibility model?**

| Choice | Response |
|--------|----------|
| A | Configuring third-party applications |
| B | Maintaining physical hardware |
| C | Securing application access and data |
| D | Managing custom Amazon Machine Images (AMIs) |

**Answer:**  
The correct answer is **B**.  
Key words: “AWS’s responsibility” and “AWS shared responsibility model”.

---

## Resources

- [AWS Cloud Security](https://aws.amazon.com/security/)
- [AWS Security Resources](https://aws.amazon.com/security/security-learning/)
- [AWS Security Blog](https://aws.amazon.com/blogs/security/)
- [Security Bulletins](https://aws.amazon.com/security/security-bulletins/)
- [Vulnerability and Penetration Testing](https://aws.amazon.com/security/penetration-testing/)
- [AWS Well-Architected Framework – Security pillar](https://d1.awsstatic.com/whitepapers/architecture/AWS-Security-Pillar.pdf)
- [IAM Best Practices Documentation](https://docs.aws.amazon.com/IAM/latest/UserGuide/best-practices.html)

---
