# Ilusalong

## Login rate limit

Before using the login rate limit, run
`database/migrations/20261118_create_login_rate_limits.sql` against the
`ilusalong` database.

Login attempts are limited to 5 failures per email and 20 failures per IP
address within 15 minutes. Reaching either limit blocks further attempts for
15 minutes. The limiter stores hashed email and IP identifiers, not their raw
values.

Expired limiter entries are removed during failed login attempts.