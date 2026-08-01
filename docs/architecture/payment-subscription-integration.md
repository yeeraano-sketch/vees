# Payment ↔ Subscription Integration

## Purpose

Defines how Payment and Subscription collaborate without violating Bounded Context boundaries.

---

# Responsibilities

## Payment

Responsible for:

- Creating payments
- Verifying payments
- Recording transactions
- Publishing payment events

Never responsible for:

- Subscription activation
- Subscription renewal
- Provider eligibility

---

## Subscription

Responsible for:

- Activating subscriptions
- Renewing subscriptions
- Cancelling subscriptions
- Work mode validation
- Eligibility

---

# Purchase Flow

Provider

↓

CreatePayment

↓

PaymentSucceeded

↓

SubscriptionActivated

↓

ProviderEligibilityUpdated

↓

Matching

---

# Renewal Flow

Provider

↓

CreatePayment

↓

PaymentSucceeded

↓

SubscriptionRenewed

↓

ProviderEligibilityUpdated

---

# Refund Flow

RefundProcessed

↓

Subscription decides

↓

SubscriptionCancelled (optional)

↓

ProviderEligibilityUpdated

---

# Failed Payment

PaymentFailed

↓

No Subscription changes

---

# Design Principles

- Payment owns money.
- Subscription owns subscription lifecycle.
- Provider owns profile.
- Matching owns assignment decisions.
- Communication is Event-Driven only.

---

Status

FROZEN

Version

1.0

