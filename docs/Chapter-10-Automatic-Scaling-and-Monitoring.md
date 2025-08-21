# Chapter 10: Automatic Scaling and Monitoring

---

### Chapter Overview

#### Topics
- Elastic Load Balancing
- Amazon CloudWatch
- Amazon EC2 Auto Scaling

#### Activities
- Elastic Load Balancing activity
- Amazon CloudWatch activity

#### Lab
- Scale and Load Balance Your Architecture
  
---

## Chapter Objectives

After finishing this chapter, you should be able to:
- Explain how Elastic Load Balancing distributes traffic across EC2 instances
- Describe how Amazon CloudWatch enables real-time monitoring of AWS resources and applications
- Explain how Amazon EC2 Auto Scaling launches and releases servers as workloads change
- Perform scaling and load balancing tasks to improve an architecture

---

## Section 1: Elastic Load Balancing

### What is Elastic Load Balancing?

- Distributes incoming application/network traffic across multiple targets (EC2, containers, IPs, Lambda) in one or more Availability Zones
- Automatically scales the load balancer as traffic changes

#### Load Balancer Types

- **Application Load Balancer (ALB):** For HTTP/HTTPS, advanced routing, containerized apps
- **Network Load Balancer (NLB):** For TCP traffic, extreme performance, static IP, millions of requests/sec
- **Classic Load Balancer (CLB):** Simple load balancing for multiple protocols

#### How ELB Works

- Register targets in target groups (ALB/NLB), or instances (CLB)
- Load balancer accepts traffic, checks health, and routes only to healthy targets
- Monitors incoming connections with listeners

#### Use Cases

- High availability and fault tolerance
- Containerized applications
- Elasticity and scalability
- Hybrid environments (VPC, on-prem)
- Invoking Lambda functions over HTTP(S)

#### Monitoring Load Balancers

- **CloudWatch metrics:** Track performance, set alarms
- **Access logs:** Detailed request info
- **CloudTrail logs:** API interactions (who/what/when/where)

#### Key Takeaways

- ELB distributes traffic across multiple targets/AZs
- Supports ALB, NLB, CLB
- Provides health checks, security, monitoring

---

## Section 2: Amazon CloudWatch

### Monitoring AWS Resources

- Provides insight into AWS resources and application health
- Answers: When to launch more EC2? Is performance/availability impacted? How much infra is used?

#### Features

- Monitors AWS resources and applications
- Collects standard and custom metrics
- Set alarms (notify via SNS, trigger Auto Scaling/actions)
- Events: Define rules to match changes and route to targets

#### CloudWatch Alarms

- Based on static thresholds, anomaly detection, or metric math
- Specify namespace, metric, statistic, period, conditions, actions

#### Example Scenarios

- EC2: Alarm if CPU > 60% for 5 min
- RDS: Alarm if connections > 10 for 1 min
- S3: Alarm if bucket size threshold met
- ELB: Alarm if healthy hosts < 5 for 10 min
- EBS: Alarm if read ops > 1,000 for 10 sec

#### Key Takeaways

- CloudWatch enables real-time monitoring of AWS resources and apps
- Track metrics, set alarms, route events, automate scaling or notifications

---

## Section 3: Amazon EC2 Auto Scaling

### Why is Scaling Important?

- Prevents unused/over-capacity and wasted resources
- Matches resource provisioning to demand

### What is EC2 Auto Scaling?

- Maintains application availability by automatically adding/removing EC2 instances
- Detects and replaces unhealthy instances
- Supports manual, scheduled, dynamic (policy-triggered), and predictive scaling

#### Auto Scaling Groups

- Logical group of EC2 instances managed for scaling
- Define min, max, and desired capacity

#### Scaling Directions

- **Scale out:** Launch new instances
- **Scale in:** Terminate instances no longer needed

#### How It Works

- Health checks, manual/scheduled/dynamic/predictive scaling
- Launch config: Template for new instances (AMI, type, IAM, security, EBS, VPC, LB)
- Dynamic scaling uses CloudWatch metrics/alarms and ELB

#### AWS Auto Scaling

- Monitors and adjusts capacity for steady performance at lowest cost
- Supports EC2, ECS tasks, DynamoDB, Aurora Replicas

#### Key Takeaways

- Scaling responds to changing resource needs
- EC2 Auto Scaling maintains availability by adjusting EC2 fleet
- Auto Scaling group + launch config = managed scaling
- Dynamic scaling uses CloudWatch + ELB
- AWS Auto Scaling is separate from EC2 Auto Scaling, supports more resources

---

## Lab: Scale and Load Balance Your Architecture

**Scenario:**  
- VPC across multiple AZs
- Public/private subnets, NAT, security groups
- RDS DB primary/secondary, web servers
- Use AMI, Application Load Balancer, launch config, Auto Scaling group, CloudWatch alarms

**Tasks:**
1. Create AMI from running instance
2. Create Application Load Balancer
3. Create launch config and Auto Scaling group
4. Automatically scale new instances within private subnet
5. Create CloudWatch alarms and monitor performance

**Final Product:**  
- Scaled, load-balanced architecture with Auto Scaling, ALB, CloudWatch monitoring

---

## Sample Exam Question

**Which service would you use to send alerts based on Amazon CloudWatch alarms?**

| Choice | Response |
|--------|----------|
| A | Amazon Simple Notification Service |
| B | AWS CloudTrail |
| C | AWS Trusted Advisor |
| D | Amazon Route 53 |

**Answer:**  
The correct answer is **A**.  
Keywords: "send alerts" and "Amazon CloudWatch alarms".

---

## Resources

- [Amazon EC2 Auto Scaling Documentation](https://docs.aws.amazon.com/autoscaling/)
- [Elastic Load Balancing Documentation](https://docs.aws.amazon.com/elasticloadbalancing/)
- [Amazon CloudWatch Documentation](https://docs.aws.amazon.com/cloudwatch/)
- [AWS Architecture Blog: Scaling and Load Balancing](https://aws.amazon.com/blogs/architecture/)

---
