---
layout: post
title: Setting up Checker Framework in IntelliJ
created: 2019-02-19 09:14:00 -0800
tags:
- Java
- IntelliJ
- Checker Framework
---
## Set up Checker Framework in IntelliJ

These are step-by-step instructions for setting up [Checker Framework][checker-framework] (CF) for a basic Java project in [IntelliJ][intellij]. This is based on my configuration:

* IntelliJ IDEA Ultimate 2018.1.5
* macOS Sierra 10.12.6

In these instructions, I'll show you how to enable CF's
We'll enable CF's nullness checking for a simple test program.

### Create IntelliJ project

From the _Welcome to IntelliJ IDEA_ window:

1. Click _Create New Project_
2. Select _Java_
3. Select _1.8_ under _Project SDK_
4. Click _Next_
5. Check _Create project from template_
6. Select _Command Line App_
7. Click _Next_
8. Enter a name under _Project name_ etc.
9. Click _Finish_

### Create test program

Replace the content of `Main.java` with:

{% gist dbf76f5f7d0c41fd47a13f2eb328aba0 CFTest_Main.java %}

Make sure that this program compiles and runs using `Ctrl+R`. It should output `null` to the console.

### Download Checker Framework dependencies

From _File_ menu:

1. Click _Project Structure&hellip;_
2. Click _Libraries_
3. Click _+_ and select _From Maven&hellip;_
4. Enter `org.checkerframework` and click the search button
5. Select `org.checkerframework:checker:1.9.10` and click _OK_ twice to add this to the project
6. Click _+_ and select _From Maven&hellip;_
7. Enter `org.checkerframework` and click the search button
8. Select `org.checkerframework:jdk8:1.9.10` and click _OK_ twice to add this to the project
9. Click _+_ and select _From Maven&hellip;_
10. Enter `org.checkerframework` and click the search button
11. Select `org.checkerframework:checker-qual:1.9.10` and click _OK_ twice to add this to the project
12. Click _OK_ to dismiss the project structure window

### Enable Checker Framework as an annotation processor

From the _IntelliJ IDEA_ application menu:

1. Click _Preferences&hellip;_
2. Expand _Build, Execution, Deployment_
3. Expand _Compiler_
4. Click _Annotation Processors_
5. Ensure that your module name appears under _Default_
6. Select your module
7. Check _Enable annotation processing_
8. Ensure _Obtain processors from project classpath_ radio button is selected
9. Under _Annotation Processors_ click _+_
10. Enter _org.checkerframework.checker.nullness.NullnessChecker_ under _Processor FQ Name_
11. Click _Apply_
12. From the navigation pane, click _Java Compiler_
13. Under _Additional command line parameters_ enter `-Xbootclasspath/p:$USER_HOME$/.m2/repository/org/checkerframework/jdk8/1.9.10/jdk8-1.9.10.jar`
14. Click _OK_

### Rebuild your project

1. Press `Cmd-F9` to rebuild

You should see the following error in the build output pane:

```
Error:(20, 33) java: [argument.type.incompatible] incompatible types in argument.
  found   : null
  required: @Initialized @NonNull String
```

This tells us that passing `null` to the constructor of `Foo` is invalid. Fix this line to pass a non-`null` string:

```java
final Foo foo = new Foo("Hello world");
```

Then press `Cmd-F9` again and the program should compile without error.

[checker-framework]: https://checkerframework.org/
[intellij]: https://www.jetbrains.com/idea/
