# Chapter 5: Networking and Content Delivery

---

### Chapter Overview

#### Topics
- Networking basics
- Amazon VPC
- VPC networking
- VPC security
- Amazon Route 53
- Amazon CloudFront

#### Lab
- Build your own VPC and launch a web server

---

## Chapter Objectives

After completing this chapter, you should be able to:
- Understand networking basics and virtual networking with Amazon VPC
- Label and design network diagrams and basic VPC architectures
- Identify steps to build a VPC and security group fundamentals
- Create and customize your own VPC
- Grasp Amazon Route 53 fundamentals
- Recognize the benefits of Amazon CloudFront

---

## Section 1: Networking Basics

### Core Concepts

- **Networks** are made up of subnets and routers.
- **IP addresses:** IPv4 (32-bit, e.g., 192.0.2.0) and IPv6 (128-bit, e.g., 2600:1f18:22ba:8c00:ba86:a05e:a5ba:00FF)
- **CIDR notation:** Used to define IP address blocks (e.g., 192.0.2.0/24)
- **OSI Model:** Seven layers (Application, Presentation, Session, Transport, Network, Data Link, Physical) that describe network interactions.

---

## Section 2: Amazon VPC

### What is Amazon VPC?

- Lets you provision a logically isolated section of the AWS Cloud to launch resources in a virtual network you define.
- Control over IP address range, subnets, route tables, and network gateways.
- Customizable security layers.

#### VPCs and Subnets

- A VPC is isolated, dedicated to your account, belongs to one region, and can span multiple AZs.
- Subnets divide a VPC, belong to one AZ, and can be public or private.
- Each VPC and subnet is assigned a CIDR block.

#### IP Addressing

- Assign private IPv4 CIDR block (e.g., /16 for 65,536 addresses, /28 for 16 addresses).
- Subnet CIDR blocks must not overlap.
- IPv6 is supported.

#### Reserved IP Addresses

- Some IPs in every subnet are reserved for internal use (e.g., network address, DNS, broadcast).

#### Public IP Address Types

- Elastic IP: manually assigned, associated with AWS account, can be remapped.
- Auto-assigned public IP: set at subnet level.

#### Elastic Network Interface

- Virtual network interface that can be attached/detached to redirect traffic.

#### Route Tables

- Set of rules to direct traffic; every subnet must be associated with a route table.
- Default route for communication within the VPC.

---

## Section 3: VPC Networking Options

### Core Networking Components

- **Internet Gateway:** Attach to VPC for outbound internet access.
- **NAT Gateway:** Allow private subnet instances to access internet for updates.
- **VPC Sharing:** Share VPC resources across accounts.
- **VPC Peering:** Connect VPCs within or across accounts and regions (no overlapping CIDRs, no transitive peering).
- **Site-to-Site VPN:** Connect AWS VPC to on-premises data center.
- **AWS Direct Connect:** Dedicated network connection from your premises to AWS.
- **VPC Endpoints:** Private connections to AWS services (Interface endpoints via PrivateLink, Gateway endpoints for S3/DynamoDB).
- **AWS Transit Gateway:** Central hub for connecting VPCs, VPNs, and Direct Connect.
  

#### Key Takeaways

- Multiple networking options: IGW, NAT, endpoints, peering, sharing, VPN, Direct Connect, Transit Gateway
- Use the VPC Wizard to implement designs.

---

## Section 4: VPC Security

### Security Groups

- Instance-level firewalls, control inbound/outbound traffic.
- Default denies all inbound, allows all outbound.
- Rules are stateful; only allow rules can be specified.

#### Custom Security Group Rules

- Allow HTTP (TCP 80), HTTPS (TCP 443), SSH (TCP 22) from defined sources.

### Network ACLs

- Subnet-level firewalls, control inbound/outbound traffic.
- Default allow all traffic; custom ACLs deny all until rules are added.
- ACLs are stateless; allow and deny rules are supported; rules are evaluated in order.

#### Security Groups vs. Network ACLs

| Attribute        | Security Groups         | Network ACLs             |
|------------------|------------------------|--------------------------|
| Scope           | Instance level          | Subnet level             |
| Supported Rules | Allow only              | Allow and Deny           |
| State           | Stateful                | Stateless                |
| Rule Order      | All rules evaluated     | Number order evaluated   |

#### Activity: Design a VPC

Scenario: Small business website on EC2, private database, highly available architecture, multiple subnets, firewall layers (security groups/ACLs).

#### Key Takeaways

- Build security into your VPC architecture with isolation, appropriate gateways, firewalls, security groups, and network ACLs.

---

## Section 5: Amazon Route 53

### What is Amazon Route 53?

- Highly available, scalable DNS web service
- Translates domain names to IP addresses
- Supports IPv4/IPv6, traffic flow, health checks, domain registration

#### Routing Policies

- Simple, weighted round robin, latency, geolocation, geoproximity, failover, multivalue answer

#### Use Cases

- Multi-region deployments, DNS failover for high availability

#### Key Takeaways

- Route 53 is core to AWS DNS, supports global routing and failover, enhances availability.

---

## Section 6: Amazon CloudFront

### Content Delivery and Network Latency

- CDN: Globally distributed caching servers that deliver static/dynamic content with low latency

### What is Amazon CloudFront?

- Fast, global, secure CDN service
- Network of edge locations and regional caches
- Deep integration with AWS, pay-as-you-go

#### CloudFront Infrastructure

- **Edge locations:** Serve popular content quickly
- **Regional edge caches:** Hold less popular content, sit between origin and global edge locations

### CloudFront Benefits

- Speed, security, programmability, cost-effectiveness

### CloudFront Pricing

- Charged for data transfer, HTTP(S) requests, invalidation requests, custom SSL options

#### Key Takeaways

- CDN accelerates content delivery worldwide
- CloudFront delivers data, videos, apps, APIs securely and quickly

---

## Sample Exam Question

**Which AWS networking service enables a company to create a virtual network within AWS?**

| Choice | Response |
|--------|----------|
| A | AWS Config |
| B | Amazon Route 53 |
| C | AWS Direct Connect |
| D | Amazon VPC |

**Answer:**  
The correct answer is **D**.  
Key concepts: "AWS networking service" and "create a virtual network".

---

## Resources

- [Amazon VPC Overview](https://docs.aws.amazon.com/vpc/latest/userguide/what-is-amazon-vpc.html)
- [Amazon VPC Connectivity Options (whitepaper)](https://docs.aws.amazon.com/whitepapers/latest/aws-vpc-connectivity-options/introduction.html)
- [One to Many: Evolving VPC Design (AWS Architecture blog)](https://aws.amazon.com/blogs/architecture/one-to-many-evolving-vpc-design/)
- [Amazon VPC User Guide](https://docs.aws.amazon.com/vpc/latest/userguide/what-is-amazon-vpc.html)
- [Amazon CloudFront Overview](https://aws.amazon.com/cloudfront/?nc=sn&loc=1)

---
