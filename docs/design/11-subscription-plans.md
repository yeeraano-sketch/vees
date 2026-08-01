# Subscription Plans

## Purpose

Defines all subscription plans, pricing, work mode permissions and trial policies.

This document is the single source of truth for subscription behavior.

---

# Plans

## Trial Plan

Duration

30 Days

Price

0 SAR

Allowed Services

- Taxi
- Delivery

Maximum Active Services

1

Notes

The Provider may activate Taxi or Delivery, but never both simultaneously.
The active service may be changed at any time during the trial period.

---

## Taxi Plan

Duration

30 Days

Price

250 SAR

Allowed Services

- Taxi

Maximum Active Services

1

---

## Delivery Plan

Duration

30 Days

Price

250 SAR

Allowed Services

- Delivery

Maximum Active Services

1

---

## Combined Plan

Duration

30 Days

Price

500 SAR

Allowed Services

- Taxi
- Delivery

Maximum Active Services

2

The Provider may enable both services simultaneously.

---

# Work Mode Rules

## Trial

Taxi OR Delivery

Only one active service.

---

## Taxi Plan

Taxi only.

---

## Delivery Plan

Delivery only.

---

## Combined Plan

Taxi AND Delivery simultaneously.

---

# Busy Rules

After accepting any Session:

- Taxi

OR

- Delivery

The Provider becomes Busy.

Busy Providers cannot receive additional requests until the active Session finishes.

---

# Matching Rules

Matching considers only Providers that:

- Have an active Subscription.
- Have the requested Service enabled.
- Are Available.
- Are not Busy.

---

# Subscription Validation

Subscription validates every requested Work Mode.

Examples

Trial + Taxi

Allowed

Trial + Taxi + Delivery

Rejected

Taxi Plan + Taxi

Allowed

Taxi Plan + Delivery

Rejected

Delivery Plan + Delivery

Allowed

Delivery Plan + Taxi

Rejected

Combined Plan + Taxi

Allowed

Combined Plan + Delivery

Allowed

Combined Plan + Taxi + Delivery

Allowed

---

# Trial Policy

The Trial Plan is configurable.

It may be enabled, disabled or modified without changing the Domain Model.

---

# Future Anti-Abuse Policy

Trial eligibility is controlled by Policy.

Possible identifiers include:

- National ID
- Driving License
- Vehicle
- Phone Number

This policy is intentionally separated from the Subscription Aggregate.

---

# Business Rules

| Rule | Description |
|------|-------------|
| BR-101 | Trial lasts 30 days. |
| BR-102 | Trial allows one active service only. |
| BR-103 | Taxi Plan enables Taxi only. |
| BR-104 | Delivery Plan enables Delivery only. |
| BR-105 | Combined Plan enables Taxi and Delivery together. |
| BR-106 | Busy Providers cannot receive additional Sessions. |
| BR-107 | Subscription validates service activation. |
| BR-108 | Trial eligibility is controlled by Policy. |

---

Status

FROZEN

Version

1.0
