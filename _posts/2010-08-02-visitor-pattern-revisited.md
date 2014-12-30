---
layout: post
title: Visitor pattern (re)visited
created: 2010-08-02 14:01:13 -0700
tags:
- Development
- Design patterns
- Java
---
I am aware that the visitor design pattern has been around in some form for years and so what I'm about to write in this post is not particularly innovative or special in any way. I just thought I'd discuss something I've been pondering for a while in my attempts to come up with interesting refactorings for the <a href="http://code.google.com/p/ductilej/">DuctileJ</a> project.

Anyway, I read <a href="https://www.re-motion.org/blogs/mix/archive/2010/04/10/virtual-methods-outside-of-classes-the-visitor-pattern.aspx
">this</a> article describing the pattern in C# and thought I'd translate the samples into Java.

<h2>Before implementing the visitor pattern</h2>
<pre><code>
import java.util.ArrayList;

class EatingException extends Exception {
    public EatingException() {
    }
}

interface Biteable {
    void acceptBite() throws EatingException;
}

interface Peelable {
    void acceptPeel() throws EatingException;
}

class Person {
    private final String name;

    public Person(String name) {
        this.name = name;
    }

    public void bite(Biteable obj) throws EatingException {
        System.out.println("Person[" + this.name + "].bite");
        obj.acceptBite();
    }

    public void peel(Peelable obj) throws EatingException {
        System.out.println("Person[" + this.name + "].peel");
        obj.acceptPeel();
    }
}

abstract class Fruit {
    public abstract void beEaten(Person eater) throws EatingException;
}

class Apple extends Fruit implements Biteable {
    private final String name;
    private int fleshUnitCount = 10;

    public Apple(String name) {
        this.name = name;
    }

    public void acceptBite() throws EatingException {
        System.out.println("Apple[" + this.name + "].acceptBite");
        if (this.fleshUnitCount <= 0) {
            throw new EatingException();
        }
        --this.fleshUnitCount;
    }

    public void beEaten(Person eater) throws EatingException {
        System.out.println("Apple[" + this.name + "].beEaten");
        while (this.hasFlesh()) {
            eater.bite(this);
        }
    }

    public boolean hasFlesh() {
        System.out.println("Apple[" + this.name + "].hasFlesh");
        return this.fleshUnitCount > 0;
    }
}

class Slice implements Biteable {
    private int fleshUnitCount = 5;

    public Slice() {
    }

    public void acceptBite() throws EatingException {
        System.out.println("Slice.acceptBite");
        if (this.fleshUnitCount <= 0) {
            throw new EatingException();
        }
        --this.fleshUnitCount;
    }

    public boolean hasFlesh() {
        System.out.println("Slice.hasFlesh");
        return this.fleshUnitCount > 0;
    }
}

class Orange extends Fruit implements Peelable {
    private final String name;
    private boolean hasPeel = true;
    private ArrayList<Slice> slices = new ArrayList<Slice>();

    public Orange(String name) {
        this.name = name;
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
    }

    public void acceptPeel() throws EatingException {
        System.out.println("Orange[" + this.name + "].acceptPeel");
        if (!this.hasPeel) {
            throw new EatingException();
        }
        this.hasPeel = false;
    }

    public void beEaten(Person eater) throws EatingException {
        System.out.println("Orange[" + this.name + "].beEaten");
        eater.peel(this);
        for (Slice slice : this.slices) {
            while (slice.hasFlesh()) {
                eater.bite(slice);
            }
        }
    }
}            

public final class WithoutVisitor {
    public static void run() {
        try {
            Person me = new Person("Richard");

            Apple apple = new Apple("Granny Smith");
            apple.beEaten(me);

            Orange orange = new Orange("Valencia");
            orange.beEaten(me);
        }
        catch (EatingException ex) {
            System.out.println("EatingException caught: " + ex);
        }
    }

    private WithoutVisitor() {
    }
}
</code></pre>

<h2>An intermediate version</h2>
<pre><code>
import java.util.ArrayList;
import java.util.Iterator;

class EatingException extends Exception {
    public EatingException() {
    }
}

interface Biteable {
    void acceptBite() throws EatingException;
}

interface Peelable {
    void acceptPeel() throws EatingException;
}

class Person {
    private final String name;

    public Person(String name) {
        this.name = name;
    }

    public void eat(Fruit fruit) throws EatingException {
        if (fruit instanceof Apple) {
            Apple apple = (Apple)fruit;
            System.out.println("Person[" + this.name + "].eat[Apple]");
            while (apple.hasFlesh()) {
                this.bite(apple);
            }
            return;
        }
        if (fruit instanceof Orange) {
            Orange orange = (Orange)fruit;
            System.out.println("Person[" + this.name + "].eat[Orange]");
            this.peel(orange);
            for (Slice slice : orange.slices()) {
                while (slice.hasFlesh()) {
                    this.bite(slice);
                }
            }
            return;
        }
        throw new EatingException();
    }

    public void bite(Biteable obj) throws EatingException {
        System.out.println("Person[" + this.name + "].bite");
        obj.acceptBite();
    }

    public void peel(Peelable obj) throws EatingException {
        System.out.println("Person[" + this.name + "].peel");
        obj.acceptPeel();
    }
}

abstract class Fruit {
}

class Apple extends Fruit implements Biteable {
    private final String name;
    private int fleshUnitCount = 10;

    public Apple(String name) {
        this.name = name;
    }

    public void acceptBite() throws EatingException {
        System.out.println("Apple[" + this.name + "].acceptBite");
        if (this.fleshUnitCount <= 0) {
            throw new EatingException();
        }
        --this.fleshUnitCount;
    }

    public boolean hasFlesh() {
        System.out.println("Apple[" + this.name + "].hasFlesh");
        return this.fleshUnitCount > 0;
    }
}

class Slice implements Biteable {
    private int fleshUnitCount = 5;

    public Slice() {
    }

    public void acceptBite() throws EatingException {
        System.out.println("Slice.acceptBite");
        if (this.fleshUnitCount <= 0) {
            throw new EatingException();
        }
        --this.fleshUnitCount;
    }

    public boolean hasFlesh() {
        System.out.println("Slice.hasFlesh");
        return this.fleshUnitCount > 0;
    }
}

class Orange extends Fruit implements Peelable {
    private final String name;
    private boolean hasPeel = true;
    private ArrayList<Slice> slices = new ArrayList<Slice>();

    public Orange(String name) {
        this.name = name;
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
    }

    public Iterable<Slice> slices() {
        return new Iterable<Slice>() {
            public Iterator<Slice> iterator() {
                return new Iterator<Slice>() {
                    private int index = 0;

                    public boolean hasNext() {
                        return this.index < slices.size() - 1;
                    }

                    public Slice next() {
                        return slices.get(++this.index);
                    }

                    public void remove() {
                    }
                };
            }
        };
    }

    public void acceptPeel() throws EatingException {
        System.out.println("Orange[" + this.name + "].acceptPeel");
        if (!this.hasPeel) {
            throw new EatingException();
        }
        this.hasPeel = false;
    }
}            

public final class NaiveApproach {
    public static void run() {
        try {
            Person me = new Person("Richard");

            Apple apple = new Apple("Granny Smith");
            me.eat(apple);

            Orange orange = new Orange("Valencia");
            me.eat(orange);
        }
        catch (EatingException ex) {
            System.out.println("EatingException caught: " + ex);
        }
    }

    private NaiveApproach() {
    }
}
</code></pre>

<h2>With the visitor design pattern</h2>
<pre><code>
import java.util.ArrayList;
import java.util.Iterator;

class EatingException extends Exception {
    public EatingException() {
    }
}

interface FruitVisitor {
    void visitApple(Apple apple) throws EatingException;
    void visitOrange(Orange orange) throws EatingException;
}

interface Biteable {
    void acceptBite() throws EatingException;
}

interface Peelable {
    void acceptPeel() throws EatingException;
}

class Person implements FruitVisitor {
    private final String name;

    public Person(String name) {
        this.name = name;
    }

    public void eat(Fruit fruit) throws EatingException {
        fruit.accept(this);
    }

    public void visitApple(Apple apple) throws EatingException {
        System.out.println("Person[" + this.name + "].eat[Apple]");
        while (apple.hasFlesh()) {
            this.bite(apple);
        }
    }

    public void visitOrange(Orange orange) throws EatingException {
        System.out.println("Person[" + this.name + "].eat[Orange]");
        this.peel(orange);
        for (Slice slice : orange.slices()) {
            while (slice.hasFlesh()) {
                this.bite(slice);
            }
        }
    }

    public void bite(Biteable obj) throws EatingException {
        System.out.println("Person[" + this.name + "].bite");
        obj.acceptBite();
    }

    public void peel(Peelable obj) throws EatingException {
        System.out.println("Person[" + this.name + "].peel");
        obj.acceptPeel();
    }
}

abstract class Fruit {
    public abstract void accept(FruitVisitor visitor) throws EatingException;
}

class Apple extends Fruit implements Biteable {
    private final String name;
    private int fleshUnitCount = 10;

    public Apple(String name) {
        this.name = name;
    }

    public void accept(FruitVisitor visitor) throws EatingException {
        visitor.visitApple(this);
    }

    public void acceptBite() throws EatingException {
        System.out.println("Apple[" + this.name + "].acceptBite");
        if (this.fleshUnitCount <= 0) {
            throw new EatingException();
        }
        --this.fleshUnitCount;
    }

    public boolean hasFlesh() {
        System.out.println("Apple[" + this.name + "].hasFlesh");
        return this.fleshUnitCount > 0;
    }
}

class Slice implements Biteable {
    private int fleshUnitCount = 5;

    public Slice() {
    }

    public void acceptBite() throws EatingException {
        System.out.println("Slice.acceptBite");
        if (this.fleshUnitCount <= 0) {
            throw new EatingException();
        }
        --this.fleshUnitCount;
    }

    public boolean hasFlesh() {
        System.out.println("Slice.hasFlesh");
        return this.fleshUnitCount > 0;
    }
}

class Orange extends Fruit implements Peelable {
    private final String name;
    private boolean hasPeel = true;
    private ArrayList<Slice> slices = new ArrayList<Slice>();

    public Orange(String name) {
        this.name = name;
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
        this.slices.add(new Slice());
    }

    public void accept(FruitVisitor visitor) throws EatingException {
        visitor.visitOrange(this);
    }

    public Iterable<Slice> slices() {
        return new Iterable<Slice>() {
            public Iterator<Slice> iterator() {
                return new Iterator<Slice>() {
                    private int index = 0;

                    public boolean hasNext() {
                        return this.index < slices.size() - 1;
                    }

                    public Slice next() {
                        return slices.get(++this.index);
                    }

                    public void remove() {
                    }
                };
            }
        };
    }

    public void acceptPeel() throws EatingException {
        System.out.println("Orange[" + this.name + "].acceptPeel");
        if (!this.hasPeel) {
            throw new EatingException();
        }
        this.hasPeel = false;
    }
}            

public final class WithVisitor {
    public static void run() {
        try {
            Person me = new Person("Richard");

            Apple apple = new Apple("Granny Smith");
            me.eat(apple);

            Orange orange = new Orange("Valencia");
            me.eat(orange);
        }
        catch (EatingException ex) {
            System.out.println("EatingException caught: " + ex);
        }
    }

    private WithVisitor() {
    }
}
</code></pre>

I'll write more on the subject later.

