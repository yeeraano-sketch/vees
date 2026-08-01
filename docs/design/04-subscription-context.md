# Subscription Context

## Purpose

The Subscription Context manages Provider subscriptions and determines whether a Provider is eligible to receive new Sessions.

It is the single source of truth for subscription lifecycle.

---

# Responsibility

## Subscription Owns

- Subscription
- Subscription Plan
- Subscription Period
- Subscription Status
- Grace Period
- Renewal History
- Work Mode Validation

---

## Subscription Does Not Own

- Provider Profile
- Payment Processing
- Session Lifecycle
- Matching
- Rating
- Notification

Payment confirms successful payment.

Subscription decides whether the Provider is eligible.

---

# Aggregate

## Aggregate Root

Subscription

---

## Responsibilities

The Subscription Aggregate is responsible for:

- Creating subscriptions
- Activating subscriptions
- Renewing subscriptions
- Expiring subscriptions
- Managing Grace Period
- Validating Work Modes
- Determining Session eligibility

---

# Value Objects

- SubscriptionPlan
- SubscriptionPeriod
- ExpirationDate
- GracePeriod
- WorkMode
- SubscriptionStatus

---

# Business Invariants

## INV-101

A Subscription belongs to exactly one Provider.

---

## INV-102

Only one Active Subscription may exist per Provider.

---

## INV-103

Every Subscription has a Start Date and an Expiration Date.

---

## INV-104

Trial allows only one active Work Mode.

---

## INV-105

Taxi Plan allows Taxi only.

---

## INV-106

Delivery Plan allows Delivery only.

---

## INV-107

Combined Plan allows Taxi and Delivery simultaneously.

---

## INV-108

Busy Providers cannot receive additional Sessions.

---

## INV-109

Renewal creates a new Subscription Period.

---

## INV-110

Expired Subscriptions cannot become Active again.

---

# Commands

- CreateSubscription
- ActivateSubscription
- RenewSubscription
- ExpireSubscription
- EndGracePeriod
- CancelSubscription
- ChangeWorkMode

---

# Domain Events

- SubscriptionCreated
- SubscriptionActivated
- SubscriptionRenewed
- SubscriptionExpired
- GracePeriodStarted
- GracePeriodEnded
- SubscriptionCancelled
- WorkModeChanged

---

# State Model

Draft

↓

Active

↓

GracePeriod

↓

Expired

Draft → Cancelled

Active → Cancelled

---

# Business Rules

| Rule | Description |
|------|-------------|
| BR-101 | Trial lasts 30 days. |
| BR-102 | Trial allows one active Work Mode. |
| BR-103 | Taxi Plan enables Taxi only. |
| BR-104 | Delivery Plan enables Delivery only. |
| BR-105 | Combined Plan enables Taxi and Delivery. |
| BR-106 | Busy Providers cannot receive new Sessions. |
| BR-107 | Only Active Subscriptions receive Sessions. |
| BR-108 | Renewal creates a new Subscription Period. |

---

# Error Model

| Code | Description |
|------|-------------|
| SUB-001 | Subscription already active |
| SUB-002 | Subscription expired |
| SUB-003 | Invalid Work Mode |
| SUB-004 | Trial restriction violated |
| SUB-005 | Grace Period ended |
| SUB-006 | Subscription cancelled |

---

# Test Matrix

## Aggregate

- Creation
- Activation
- Renewal
- Expiration
- Cancellation

---

## Plans

- Trial
- Taxi
- Delivery
- Combined

---

## Work Modes

- Taxi
- Delivery
- Taxi + Delivery

---

## Contracts

- SubscriptionActivated
- SubscriptionExpired
- WorkModeChanged

---

# Architecture Review

- [x] Aggregate
- [x] Invariants
- [x] Commands
- [x] Events
- [x] Business Rules
- [x] Error Model
- [x] Tests

Status

PASSED

---

# Subscription Context v2.0

Status

FROZEN

Architecture Review

PASSED

Implementation Readiness

PASSED
