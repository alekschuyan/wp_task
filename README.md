Task: create plugin for external link options.

Database is in _db_ folder.
Password is in _info_ folder.

Plugin name: Linkoption.
Plugin settings page: /wp-admin/options-general.php?page=linkoption

Available plugin options and fuctions:
- Adds attributes for external links in content when outputting the_content().
- Internal links are ignored.
- Enable nofollow attribute for external links (rel="nofollow").
- Open links in a new tab (target="_blank").
- Selection of post types.