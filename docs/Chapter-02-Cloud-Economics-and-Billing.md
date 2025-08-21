# Chapter 2: Cloud Economics and Billing

---

### Chapter Overview

#### Topics
- Fundamentals of pricing in AWS
- Understanding Total Cost of Ownership (TCO)
- AWS Organizations
- AWS Billing and Cost Management
- AWS Technical Support
  
---

## Section 1: Fundamentals of Pricing

### AWS Pricing Model

There are three fundamental drivers of AWS cost:
- **Compute:** Charged per hour/second (Linux only), cost varies by instance type
- **Storage:** Typically charged per GB
- **Data Transfer:** Outbound data is charged, inbound is generally free (some exceptions), typically charged per GB

#### How do you pay for AWS?

- **Pay for what you use:** Only pay for the services you consume, without large upfront expenses.
- **Pay less when you reserve:** Reserved Instances (RIs) let you save up to 75%. There are three options:
  - All Upfront Reserved Instance (AURI): largest discount
  - Partial Upfront Reserved Instance (PURI): lower discounts
  - No Upfront Payments Reserved Instance (NURI): smallest discount
- **Pay less by using more:** Volume-based discounts and tiered pricing for services like Amazon S3, EBS, EFS—the more you use, the less you pay per GB.
- **Pay even less as AWS grows:** AWS passes savings from economies of scale to customers. Since 2006, AWS has lowered prices over 75 times.
- **Custom pricing:** Available for high-volume projects with unique requirements.

#### AWS Free Tier

The Free Tier lets new customers gain hands-on experience with AWS services free for one year.

#### Services with no charge

Some AWS services have no direct charge:
- Amazon VPC
- Elastic Beanstalk**
- Auto Scaling**
- AWS CloudFormation**
- AWS Identity and Access Management (IAM)

> **Note:** There may be charges for other AWS services used in conjunction.

---

## Section 2: Total Cost of Ownership (TCO)

### On-premises vs. Cloud

Traditional infrastructure requires significant resources and administration, with contracts, upfront costs, and slow scaling. With AWS Cloud, there's no upfront expense—you pay for what you use, scale up or down as needed, and benefit from self-service infrastructure.

### What is TCO?

Total Cost of Ownership (TCO) helps estimate both direct and indirect costs of a system.  
Use TCO to:
- Compare costs of running infrastructure on-premises vs. AWS
- Budget and justify moving to the cloud

### TCO Considerations

1. **Server Costs:** Hardware (servers, racks, PDUs, switches), software (OS, licenses), maintenance
2. **Storage Costs:** Disks, SAN/FC switches, administration
3. **Network Costs:** LAN switches, bandwidth, load balancers, network administration
4. **IT Labor Costs:** Server, storage, network administration
5. **Facilities:** Space, power, cooling

### On-premises vs. All-in-Cloud Savings

You can save up to 96% annually by moving infrastructure to AWS. Example: Over three years, you could save $159,913, including business-level support and EC2 Reserved Instances.

### AWS Pricing Calculator

Use the AWS Pricing Calculator to:
- Estimate monthly costs
- Find ways to reduce costs
- Model solutions before building
- Explore contract terms and available instance types
- Name and group your estimates

#### Reading an estimate
- First 12 months total
- Total upfront
- Total monthly

### Additional Benefit Considerations

**Hard Benefits**
- Reduced spending on compute, storage, networking, security
- Lower hardware/software purchase (capex)
- Reduced operational costs, backup, disaster recovery
- Fewer operations personnel

**Soft Benefits**
- Reuse of services and apps for flexible solutions
- Increased developer productivity
- Improved customer satisfaction
- Agile business processes for new opportunities
- Greater global reach

### Case Study: TCO

#### Background
- Global company with 200+ locations
- 500 million customers, $3 billion annual revenue

#### Challenge
- Rapidly deploy new solutions
- Upgrade aging equipment

#### Criteria
- Broad solution for all workloads
- Ability to modify processes for efficiency and cost reduction
- Eliminate repetitive tasks (e.g., patching)
- Achieve positive ROI

#### Solution
- Migrated on-premises data center to AWS
- Eliminated 205 servers (90%)
- Moved almost all applications to AWS
- Adopted 3-year EC2 Reserved Instances

#### Results
- Improved growth and operational efficiency
- Optimized resources and robust security
- Enhanced disaster recovery and computing capacity
- Faster speed to market—new businesses provisioned in a day, services deployed in minutes
- Continuous cost optimization

---

## Section 3: AWS Organizations

### Introduction

AWS Organizations enables policy-based and group-based account management, automation via APIs, and consolidated billing.

#### Key features and benefits
- Policy-based and group-based account management
- APIs for automation
- Consolidated billing

#### Security with AWS Organizations

- **IAM Policies:** Allow/deny access to AWS services for users, groups, and roles
- **Service Control Policies (SCPs):** Allow/deny access for individuals or groups in organizational units (OUs)

#### Organizations Setup

1. Create Organization
2. Create organizational units
3. Create service control policies
4. Test restrictions

#### Accessing AWS Organizations

- AWS Management Console
- AWS CLI tools
- SDKs
- HTTPS Query APIs

---

## Section 4: AWS Billing and Cost Management

### Introducing AWS Billing and Cost Management

AWS provides tools like:
- AWS Budgets
- AWS Cost and Usage Report
- AWS Cost Explorer

#### Billing Dashboard

The Billing Dashboard helps you view monthly bills, forecast and track costs, and review cost and usage reporting.


---

## Section 5: Technical Support

### AWS Support

AWS offers a combination of tools and expertise for:
- Experimenting with AWS
- Production and business-critical use

#### Support Plans

Four support plans:
- **Basic Support:** Resource Center, Service Health Dashboard, FAQs, forums, health check support
- **Developer Support:** Early development support
- **Business Support:** For production workloads
- **Enterprise Support:** For mission-critical workloads

#### Proactive guidance

- **Technical Account Manager (TAM)**
- **AWS Trusted Advisor:** Best practices
- **AWS Support Concierge:** Account assistance

---

## Sample Exam Question

**Which AWS service provides infrastructure security optimization recommendations?**

| Choice | Response |
|--------|----------|
| A | AWS Price List Application Programming Interface (API) |
| B | Reserved Instances |
| C | AWS Trusted Advisor |
| D | Amazon EC2 Spot Fleet |

**Answer:**  
The correct answer is **C**.  
The keyword in the question is "recommendations".

---

## Resources

- [AWS Economics Center](http://aws.amazon.com/economics/)
- [AWS Pricing Calculator](https://calculator.aws/#/)
- [Case studies and research](http://aws.amazon.com/economics/)
- [Additional pricing exercises](https://dx1572sre29wk.cloudfront.net/cost/)

---
