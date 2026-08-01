# Payment Context

## Purpose

The Payment Context is responsible for processing subscription payments.

It verifies successful payment transactions and publishes payment events.

Payment never decides subscription eligibility.

---

# Responsibility

## Payment Owns

- Payment
- Payment Transaction
- Payment Status
- Payment Reference
- Payment Method

---

## Payment Does Not Own

- Subscription
- Provider
- Matching
- Session
- Rating
- Notification

Payment confirms payment only.

Subscription decides whether to activate or renew a subscription.

---

# Aggregate

## Aggregate Root

Payment

---

## Responsibilities

The Payment Aggregate is responsible for:

- Creating payment transactions
- Verifying successful payment
- Recording payment history
- Preventing duplicate payments
- Publishing payment events

---

# Value Objects

- PaymentId
- PaymentAmount
- PaymentMethod
- PaymentReference
- PaymentStatus
- PaymentTimestamp


---

# Business Invariants

## INV-201

Every Payment belongs to exactly one Provider.

---

## INV-202

Every Payment references exactly one Subscription Plan.

---

## INV-203

A successful Payment cannot be modified.

---

## INV-204

Duplicate Payment References are prohibited.

---

## INV-205

Payment Amount must match the selected Subscription Plan.


---

# Commands

- CreatePayment
- VerifyPayment
- CompletePayment
- FailPayment
- RefundPayment

---

# Domain Events

- PaymentCreated
- PaymentVerified
- PaymentSucceeded
- PaymentFailed
- PaymentRefunded

---

# State Model

Pending

↓

Verified

↓

Succeeded

Pending

↓

Failed

Succeeded

↓

Refunded

---

# Business Rules

| Rule | Description |
|------|-------------|
| BR-201 | Every Payment belongs to exactly one Provider. |
| BR-202 | Payment amount must match the selected Subscription Plan. |
| BR-203 | Duplicate payment references are prohibited. |
| BR-204 | Successful Payments are immutable. |
| BR-205 | Only verified Payments may succeed. |
| BR-206 | Refunds are allowed only for successful Payments. |

---

# Error Model

| Code | Description |
|------|-------------|
| PAY-001 | Invalid payment amount |
| PAY-002 | Duplicate payment reference |
| PAY-003 | Payment verification failed |
| PAY-004 | Payment already completed |
| PAY-005 | Refund not allowed |
| PAY-006 | Unsupported payment method |

---

# Test Matrix

## Aggregate

- Payment creation
- Verification
- Successful payment
- Failed payment
- Refund

---

## Value Objects

- PaymentAmount
- PaymentMethod
- PaymentReference

---

## Contracts

- PaymentSucceeded
- PaymentFailed
- PaymentRefunded

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

# Payment Context v1.0

Status

FROZEN

Architecture Review

PASSED

Implementation Readiness

PASSED

