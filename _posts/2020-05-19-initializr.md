---
layout: post
title: How I use Spring Initializr
created: 2020-05-19 14:02:00 -0700
tags:
- Spring
- Java
---
# Create boilerplate project

* Go [here][initializr]
* Select _Gradle Project_ under _Project_
* Select _Java_ under _Language_
* Select _2.3.0_ under _Spring Boot_
* Under _Project Metadata_
    * Enter _org.rcook_ in _Group_
    * Enter _myapp_ in _Artifact_
    * Click _Jar_ under _Packaging_
    * Click _11_ under _Java_
* Under _Dependencies_ click _Add dependencies&hellip;_ and add the following dependencies:
    * _Spring Boot DevTools_
    * _Spring Web_
    * _Spring Security_
    * _JDBC API_
    * _PostgreSQL Driver_
* Click _Download_

# Unpack project

Open a terminal and go to your source code directory and unzip the downloaded file:

```
unzip ~/Downloads/myapp.zip
cd myapp/
git init
git add .
git config user.email me@email.org
git commit -m 'Initial commit'
git clean -fxd
```

# Open project in IntelliJ

* Start [IntelliJ][intellij]
* Navigate to `myapp` directory created earlier and open the project
* Verify that the app builds properly with _Cmd+F9_
* You can try to run the app with _Ctrl+R_ but it will fail with _Failed to configure a DataSource: 'url' attribute is not specified and no embedded datasource could be configured._&mdash;we'll fix this soon

# Fix name of application class

Rename the main application to give it a less crappy name:

* Right-click on _MyappApplication_ under _org.rcook.myapp_ and select _Refactor > Rename&hellip;_
* Enter _App_ and click _Refactor_
* Click _Select all_ in the _Rename Tests_ dialog
* Click _OK_

Commit the changes to Git:

```
git add .
git commit -m 'Rename application class'
```

Replace its content with the following:

```java
package org.rcook.myapp;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.servlet.config.annotation.EnableWebMvc;

@SpringBootApplication
@EnableWebMvc
public class App {
    public App() {
    }

    public static void main(String[] args) {
        SpringApplication.run(App.class, args);
    }
}
```

Now fix the name of the run configuration:

* Go to _Run > Edit Configurations&hellip;_
* Click on _MyappApplication_
* Enter _App_ in _Name_ to rename
* Click _OK_

# Add application-level configuration

Create a primary configuration class:

* Right-click on `org.rcook.myapp` and select _New > Java Class_
* Enter `AppConfig`

Update the content to the following:

```java
package org.rcook.myapp;

import org.springframework.boot.jdbc.DataSourceBuilder;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import javax.sql.DataSource;

@Configuration
public class AppConfig {
    @Bean
    public DataSource dataSource() {
        return DataSourceBuilder.create().build();
    }
}
```

# Create an MVC landing page

* Right-click _org.rcook.myapp_ and select _New > Java Class_
* Enter _HomeController_ and press Enter

Set its content to the following:

```java
package org.rcook.myapp;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
public class HomeController {
    @RequestMapping("/")
    @ResponseBody
    public String index() {
        return "Hello world";
    }
}
```

# Create a REST API

* Right-click _org.rcook.myapp_ and select _New > Java Class_
* Enter _WidgetController_ and press Enter

Set its content to the following:

```java
package org.rcook.myapp;

import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.HashMap;

import static java.util.Arrays.asList;

@RestController
@RequestMapping("/widgets")
public class WidgetController {
    @RequestMapping("")
    public HashMap<String, Object> getWidgets() {
        return new HashMap<>() {{
            put("widgets", asList(1, 2, 3));
        }};
    }

    @RequestMapping("/{id}")
    public HashMap<String, Object> getWidget(@PathVariable int id) {
        return new HashMap<>() {{
            put("id", id);
        }};
    }
}
```

# Run the application

* Start the app by pressing _Ctrl+R_
* Grab the generated password which will look something like _Using generated security password: f4852173-c7fb-4565-90dc-807ccf835d0d_
* Open a browser and navigate to _http://localhost:8080_
* Under _Please sign in_
    * Enter _user_ in _Username_
    * Enter the random password in _Password_
    * Click _Sign in_
* You should see _Hello world_ in the browser
* Navigate to _http://localhost:8080/widgets/1_ and you should see some JSON in the browser

Note that the random security password will change on each launch of the app.

# Use YAML application properties

* Right-click on _application.properties_ under _resources_
* Enter _application.yml_

Enter some configuration like the following:

```yaml
db0db:
  datasource:
    type: com.zaxxer.hikari.HikariDataSource
    driverclassname: org.postgresql.Driver
    jdbcurl: jdbc:postgresql://localhost:5432/db0
    username: postgres
    password: mysecretpassword
    leakdetectionthreshold: 10000
```

# Update controller

Replace `AppConfig.java` with:

```java
package org.rcook.myapp;

import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.boot.jdbc.DataSourceBuilder;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import javax.sql.DataSource;

@Configuration
public class AppConfig {
    @Bean(name = "db0DataSource")
    @ConfigurationProperties(prefix = "db0db.datasource")
    public DataSource dataSource() {
        return DataSourceBuilder.create().build();
    }
}
```

Replace `WidgetController.java` with:

```java
package org.rcook.myapp;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import javax.sql.DataSource;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

@RestController
@RequestMapping("/widgets")
public class WidgetController {
    @Autowired
    @Qualifier("db0DataSource")
    @SuppressWarnings("initialization.fields.uninitialized")
    private DataSource db0DataSource;

    @RequestMapping("")
    public List<Object> getWidgets() {
        try (final var connection = db0DataSource.getConnection();
             final var stmt = connection.createStatement();
             final var resultSet = stmt.executeQuery("SELECT id, name FROM widgets")) {
            final var widgets = new ArrayList<>();
            while (resultSet.next()) {
                widgets.add(new HashMap<String, Object>() {{
                    put("id", resultSet.getInt("id"));
                    put("name", resultSet.getString("name"));
                }});
            }
            return widgets;
        } catch (final SQLException e) {
            throw new RuntimeException(e);
        }
    }

    @RequestMapping("/{id}")
    public HashMap<String, Object> getWidget(@PathVariable int id) {
        try (final var connection = db0DataSource.getConnection();
             final var stmt = connection.prepareStatement("SELECT id, name FROM widgets WHERE id = ?")) {
            stmt.setInt(1, id);
            try (final var resultSet = stmt.executeQuery()) {
                resultSet.next();
                return new HashMap<String, Object>() {{
                    put("id", resultSet.getInt("id"));
                    put("name", resultSet.getString("name"));
                }};
            }
        } catch (final SQLException e) {
            throw new RuntimeException(e);
        }
    }
}
```

[initializr]: https://start.spring.io/
[intellij]: https://www.jetbrains.com/idea/
