# Chapter 9: Cloud Architecture

---

### Chapter Overview

#### Topics
- AWS Well-Architected Framework
- Reliability and High Availability
- AWS Trusted Advisor

#### Activities
- AWS Well-Architected Framework Design Principles
- Interpreting AWS Trusted Advisor Recommendations

---

## Chapter Objectives

After finishing this chapter, you should be able to:
- Describe the AWS Well-Architected Framework and its six pillars
- Identify Well-Architected Framework design principles
- Explain the importance of reliability and high availability
- Describe how AWS Trusted Advisor helps customers
- Interpret Trusted Advisor recommendations

---

## Section 1: AWS Well-Architected Framework

### What is the AWS Well-Architected Framework?

- A guide for designing cloud architectures that are secure, high-performing, resilient, and efficient
- Provides a consistent approach for evaluating and implementing cloud architectures
- Shares best practices learned from reviewing customer platforms

#### The Six Pillars

1. **Operational Excellence**
   - Run and monitor systems to deliver business value and continually improve processes
   - Principles: operations as code, frequent small changes, refine procedures, anticipate failure, learn from events

2. **Security**
   - Protect information, systems, and assets through risk assessments and mitigation
   - Principles: strong identity foundation, traceability, security at all layers, automate security, protect data, keep people away from data, prepare for events

3. **Reliability**
   - Ensure workloads perform correctly and consistently
   - Principles: automatic recovery, test recovery, horizontal scaling, stop guessing capacity, manage change via automation

4. **Performance Efficiency**
   - Use resources efficiently and evolve as demand changes
   - Principles: democratize technologies, go global fast, use serverless, experiment, mechanical sympathy

5. **Cost Optimization**
   - Avoid unnecessary costs and optimize spending
   - Principles: cloud financial management, consumption model, measure efficiency, avoid undifferentiated heavy lifting, analyze and attribute expenditure

6. **Sustainability**
   - Design for environmental sustainability (recent addition, not detailed in original material)

#### Activity: Apply Each Pillar

- For each pillar, review a sample architecture (AnyCompany) and discuss the current and future state, and agree on the top improvements.

---

## Section 2: Reliability and Availability

### Core Concepts

- **Reliability:** Measure of a system's ability to provide functionality when needed (MTBF - Mean Time Between Failures)
- **Availability:** Percent uptime (e.g., 99.9% = "three nines"), calculated as normal operation time / total time
- **High Availability:** Systems withstand degradation and minimize downtime, ideally with minimal human intervention

#### Factors Influencing Availability

- **Fault Tolerance:** Built-in redundancy to keep applications running
- **Recoverability:** Policies and procedures for restoring service after failures
- **Scalability:** Ability to handle increased capacity without changing design

#### Key Takeaways

- Reliability = consistent function when needed, measured in MTBF
- Availability = percent of time the system works correctly
- Design for fault tolerance, recoverability, scalability

---

## Section 3: AWS Trusted Advisor

### What is AWS Trusted Advisor?

- An online tool offering real-time guidance to help you provision AWS resources according to best practices
- Provides recommendations in five categories:
  - Cost Optimization
  - Performance
  - Security
  - Fault Tolerance
  - Service Limits

#### Example Recommendations

1. **MFA on Root Account**
   - Enable MFA on the root user for security

2. **IAM Password Policy**
   - Enforce strong password policies for IAM users

3. **Security Groups – Unrestricted Access**
   - Restrict security group rules to necessary IPs only

4. **Amazon EBS Snapshots**
   - Regularly back up volumes with snapshots

5. **Amazon S3 Bucket Logging**
   - Enable bucket logging for security audits

#### Key Takeaways

- Trusted Advisor helps optimize your AWS environment with actionable, real-time recommendations
- Covers cost, performance, security, fault tolerance, and service limits

---

## Chapter Wrap-Up

### Summary

You now know how to:
- Describe the AWS Well-Architected Framework and its pillars
- Use Well-Architected design principles to evaluate cloud architectures
- Understand the importance of reliability, availability, and high availability
- Use AWS Trusted Advisor for best practice recommendations

---

## Knowledge Check

---

## Sample Exam Question

**A SysOps engineer working at a company wants to protect their data in transit and at rest. What services could they use to protect their data?**

| Choice | Response |
|--------|----------|
| A | Elastic Load Balancing |
| B | Amazon Elastic Block Storage (Amazon EBS) |
| C | Amazon Simple Storage Service (Amazon S3) |
| D | All of the above |

**Answer:**  
The correct answer is **D**.  
Keywords: "protect their data in transit and at rest".

---

## Resources

- [AWS Well-Architected website](https://aws.amazon.com/architecture/well-architected/?wa-lens-whitepapers.sort-by=item.additionalFields.sortDate&wa-lens-whitepapers.sort-order=desc)
- [AWS Well-Architected Labs](https://wellarchitectedlabs.com/)
- [AWS Trusted Advisor Best Practice Checks](https://docs.aws.amazon.com/awssupport/latest/user/trusted-advisor-check-reference.html)

---
