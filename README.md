<img src="https://raw.githubusercontent.com/bymayo/craft-strava-sync/master/resources/icon.png" width="70">

# Follow Plugin for Craft CMS 3.x

Follow is a Craft CMS plugin that lets users follow elements within Craft. E.g. Users can follow other users, and create a 'Following List', or follow categories to then generate a bespoke entries feed.

https://plugins.craftcms.com/follow

## Features

- Follow Craft and other plugin elements (E.g. Users, Categories, Tags)
- Generate a 'Following' and 'Followers' list for a user.

## Requirements

- Craft CMS 3.x
- MySQL

## Install

- Install via the Plugin Store in the Craft Admin CP by searching for `Follow`

OR

- Install with Composer via `composer require bymayo/follow` from your project directory
- Install the plugin in the Craft Control Panel under `Settings > Plugins`

## Configuration

As a security feature the plugin is limited by default to only allowing users to follow certain element classes:

```
craft\elements\User
craft\elements\Tag
craft\elements\Category
```

If you wish to allow users to follow a plugins element class you can optionally add it to the `allowedElementClasses` config array.

Or, if you only want users to be able to follow other users you can update this array to only include the `craft\elements\User` class.

You update these settings by creating a `follow.php` file in your projects `config` folder. See the `config.php` in this plugin to see all available options.

## Templating

- [Follow URL](#follow-url)
- [Unfollow URL](#unfollow-url)
- [Check](#check)
- [Following](#following)
- [Followers](#followers)

### Follow URL
To allow the `currentUser` to follow an element you can use the `followUrl` method to output the correct URL. You simply pass an element ID to it, whether this is a `user`, `category` or `tag` ID is up to you:

```
<a href="{{ craft.follow.followUrl(user.id) }}">Follow User</a>
```

### Unfollow URL
To then let the `currentUser` unfollow an element you can use the `unfollowUrl` method to output the correct URL. You simply pass an element ID to it, whether this is a `user`, `category` or `tag` ID:

```
<a href="{{ craft.follow.unfollowUrl(user.id) }}">Unfollow User</a>
```

### Check
If you want to check to see if the `currentUser` is following or not following a particular element use the `check` method. Simply pass an element ID to it, whether this is a `user`, `category` or `tag` ID:

```
{% if craft.follow.check(user.id) %}
   <a href="{{ craft.follow.unfollowUrl(user.id) }}">Unfollow User</a>
{% else %}
   <a href="{{ craft.follow.followUrl(user.id) }}">Follow User</a>
{% endif %}
```

You can optionally pass a different user ID to the `check` method to check a different users following a particular element:

```
{% if craft.follow.check(category.id, user.id) %}
   <a href="{{ craft.follow.unfollowUrl(category.id) }}">Unfollow Category</a>
{% else %}
   <a href="{{ craft.follow.followUrl(category.id) }}">Follow Category</a>
{% endif %}
```

### Following
To get a list of users the current logged in user is following you use the `following` method. Then pass it's results in to the correct `Element Query`, in this case `craft.users`.

```
{% set users = craft.follow.following() %}

{% for user in craft.users.id(users) %}
   {{ user.fullName }}<br />
{% endfor %}
```

By default the `following` method will always get followed elements based on the `currentUser` and the `craft\elements\User` class.

You can optionally pass different parameters to change the user. E.g. If you wanted to display a different users following list, or if you wanted to get a list of categories a particular user is following:

```
{% set params = {
   userId: user.id,
   elementClass: 'craft\elements\Category'
} %}

{% set categories = craft.follow.following(params) %}

{% for category in craft.categories.id(categories) %}
   {{ category.title }}<br />
{% endfor %}
```

### Followers
To see what users are following a particular element, you can use the `following` method. By default this will get the `currentUser` followers list, but you can optionally pass a different element ID to it. Whether this is a `user.id` or `category.id` etc.

```
{% set users = craft.follow.followers(user.id) %}

{% for user in craft.users.id(users) %}
   {{ user.fullName }}<br />
{% endfor %}
```

## Examples
I've put together a few example files to create more complex features. E.g. If you want to generate a 'Feed' of entries a user is following, or get following / follower counts etc.

- Users Followers
- User Following
- Followers / Following Count
- Follow Categories
- Follow Tags
- Dashboard Entries Feed
- Commerce 
- Basic Wishlist
- Basic Like / Unlike

## Support

If you have any issues (Surely not!) then I'll aim to reply to these as soon as possible. If it's a site-breaking-oh-no-what-has-happened moment, then hit me up on the Craft CMS Discord - @bymayo

## Roadmap

* Different lists per `siteId`.
* Ajax for follow buttons .
* Limits on queries.
* Auto output users elements, rather than passing a list.
* Notifications.
* Accept / Deny the follow request.

## Credits

Brought to you by [ByMayo](http://bymayo.co.uk)
