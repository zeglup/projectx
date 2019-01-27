Testing
=======

Current
````
api-platform
easyadmin
SF Workflow
graphviz
````
Todo

````
link easyadmin event to workflow events
link api-platform with workflow : https://gist.github.com/soyuka/7c75933a6ae3d64940bb1d1f0d9fa9da
intl to workflow
````


Install
````
bin/console doc:sch:update --force
bin/console doc:fix:load -n
bin/console server:run
````

Dump graphs

````
php bin/console workflow:dump blog_publishing --dump-format=puml | java -jar bin/plantuml.jar -p  > public/img/graph_blog_publishing.png
````