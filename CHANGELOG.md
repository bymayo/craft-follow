# Follow Changelog

## 5.1.0 - 2026-02-22 [CRITICAL]

### Fixed

- Open redirect vulnerability in follow/unfollow actions. Redirect parameter is now validated via `redirectToPostedUrl()`. Could cause a potential phishing attack.
- Follow and unfollow actions now require authentication and POST requests to prevent CSRF attacks.
- `toggle()` method having inverted logic (follow when already following, unfollow when not following).
- `createFollow()` returning `true` even when the database save failed, and leaving transactions uncommitted.
- `deleteFollow()` throwing a fatal error on race conditions when the record is already deleted.

### Removed

- Unused `FollowService` import and stale composer.json component reference.

## 5.0.1 - 2024-05-30

### Changed

- Icon to a new shiny (literally) icon

## 5.0.0 - 2024-05-30

### Changed

- Craft 5 compatibility

## 2.0.0 - 2022-06-17

### Changed

- Now requires PHP ^8.0.0.
- Now requires Craft CMS ^4.0.0

## 1.0.5 - 2020-07-30

### Added

- craft\elements\Entry is now enabled by default for allowedElementClasses

## 1.0.4 - 2020-06-22

### Removed

- Settings page is no longer available through the CP. Use `config/follow.php` to set settings per environment

## 1.0.3 - 2020-06-19

### Added

- `followingTotal` and `followersTotal` method

## 1.0.2 - 2020-06-19

### Changed

- Updated documentation URL
- `check` method now requires parameters. See documentation.

### Added

- `following` method can now be output as a string or array. This works well when trying to get a count for amount of followers & following.

## 1.0.1 - 2019-03-27

### Changed

- Updated Icon
- Minor tidy up of files

## 1.0.0 - 2019-03-27

### Added

- Initial release
