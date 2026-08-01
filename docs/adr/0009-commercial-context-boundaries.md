# ADR-0009

# Commercial Context Boundaries

Status

Accepted

---

## Context

The platform separates commercial responsibilities across multiple Bounded Contexts.

Payment manages financial transactions.

Subscription manages subscription lifecycle.

Provider manages provider identity.

Matching decides provider eligibility for incoming requests.

Maintaining strict boundaries prevents business logic leakage across contexts.

---

## Decision

Payment never activates, renews or cancels subscriptions directly.

Payment publishes domain events only.

Subscription consumes payment events and decides how subscription state changes.

Matching consumes subscription events and updates provider eligibility.

---

## Event Flow

PaymentSucceeded

↓

Subscription

↓

SubscriptionActivated

↓

ProviderEligibilityUpdated

↓

Matching

---

RefundProcessed

↓

Subscription

↓

SubscriptionCancelled (optional)

↓

ProviderEligibilityUpdated

---

## Consequences

Benefits

- Strong Separation of Concerns
- Independent evolution
- Easier testing
- Replaceable payment gateways
- Clear business ownership

Trade-offs

- Eventual consistency
- More domain events

---

## Decision Owner

Architecture

---

Status

ACCEPTED

