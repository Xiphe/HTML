Base
====

Basic logic for new projects.

Provides singleton, configuration, callback and basic api methods.


Changelog
---------

### 1.1.0
* introduce protected $_defaultConfiguration array
* configuration can be changed more easy by calling initConfig or i on a singleton
* doCallback now has a third parameter to allow return of results (filter-mode) instead of $this


Todo
----


License
-------

Copyright (C) 2013 Hannes Diercks

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.