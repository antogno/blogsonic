# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [Version 1.0.4][v1.0.4] - 2022-04-07
### Added
- Icons for the login, logout and Profile links.

### Changed
- Blogs search filters are now GET parameters.
- The number of Blogs to show is now an input field instead of a selection.
- The Blogs and Profile links in the navbar swapped places.
- If an user is logged in, the Profile link in the navbar shows its username.

### Fixed
- Input fields formatting on small displays.
- Better visualization of the navbar on large displays.
- Language selection bug on the Profile edit form.
- The password change is only successful if the email notification is sent correctly.

## [Version 1.0.3][v1.0.3] - 2021-12-17
### Added
- You can now toggle the password fields visibility.
- Placeholders in the edit Profile form.

### Changed
- When trying to post an invalid Blog, the fields don't lose their values after the page reloads.

### Fixed
- Minor bugs in the search bar.

## [Version 1.0.2][v1.0.2] - 2021-10-05
### Changed
- Gender and phone fields are no longer mandatory when registering.
- When editing your Profile you can also edit your username, email and phone.
- The language switcher now shows the current language.

### Fixed
- Blogs search filters didn't work correctly in certain timezones.
- In the registration form, when the value of the username, email or phone fields were invalid and then quickly cleared, the register button didn't update.

## [Version 1.0.1][v1.0.1] - 2021-10-04
### Added
- When registering you can see right away if the username, email and phone you entered are valid or not.

### Changed
- If an invalid form is sent when registering, the fields don't lose their values after the page reloads.

## [Version 1.0.0][v1.0.0] - 2021-10-03
### Initial release

[Unreleased]: https://github.com/antogno/blogsonic/compare/v1.0.4...HEAD
[v1.0.4]: https://github.com/antogno/blogsonic/compare/v1.0.3...v1.0.4
[v1.0.3]: https://github.com/antogno/blogsonic/compare/v1.0.2...v1.0.3
[v1.0.2]: https://github.com/antogno/blogsonic/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/antogno/blogsonic/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/antogno/blogsonic/releases/tag/v1.0.0
