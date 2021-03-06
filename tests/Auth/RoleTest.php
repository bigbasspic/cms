<?php

namespace Tests\Auth;

use Tests\TestCase;
use Statamic\Auth\File\Role;
use Illuminate\Support\Collection;

class RoleTest extends TestCase
{
    /** @test */
    function it_gets_and_sets_the_title()
    {
        $role = new Role;
        $this->assertNull($role->title());

        $return = $role->title('Test');

        $this->assertEquals('Test', $role->title());
        $this->assertEquals($role, $return);
    }

    /** @test */
    function it_gets_and_sets_the_handle()
    {
        $role = new Role;
        $this->assertNull($role->handle());

        $return = $role->handle('test');

        $this->assertEquals('test', $role->handle());
        $this->assertEquals($role, $return);
    }

    /** @test */
    function it_gets_and_adds_permissions()
    {
        $role = new Role;
        $this->assertInstanceOf(Collection::class, $role->permissions());
        $this->assertCount(0, $role->permissions());

        $return = $role->addPermission('one');
        $role->addPermission(['two', 'three']);

        $this->assertInstanceOf(Collection::class, $role->permissions());
        $this->assertEquals(['one', 'two', 'three'], $role->permissions()->all());
        $this->assertEquals($role, $return);
    }

    /** @test */
    function it_sets_all_permissions()
    {
        $role = new Role;
        $role->addPermission('one');

        $return = $role->permissions(['two', 'three']);

        $this->assertInstanceOf(Collection::class, $role->permissions());
        $this->assertEquals(['two', 'three'], $role->permissions()->all());
        $this->assertEquals($role, $return);
    }

    /** @test */
    function permissions_get_deduplicated()
    {
        $role = new Role;
        $role->addPermission(['foo', 'bar']);
        $role->addPermission(['foo', 'baz']);

        $this->assertEquals(['foo', 'bar', 'baz'], $role->permissions()->all());
    }

    /** @test */
    function it_removes_permissions()
    {
        $role = (new Role)->addPermission(['foo', 'bar', 'baz', 'qux']);

        $return = $role->removePermission('foo');
        $role->removePermission(['baz', 'qux']);

        $this->assertEquals(['bar'], $role->permissions()->all());
        $this->assertEquals($role, $return);
    }

    /** @test */
    function it_checks_if_it_has_permission()
    {
        $role = (new Role)->addPermission('foo');

        $this->assertTrue($role->hasPermission('foo'));
        $this->assertFalse($role->hasPermission('bar'));
    }

    /** @test */
    function it_checks_if_it_has_super_permissions()
    {
        $superRole = (new Role)->addPermission('super');
        $nonSuperRole = (new Role)->addPermission('something else');

        $this->assertTrue($superRole->isSuper());
        $this->assertFalse($nonSuperRole->isSuper());
    }

    /** @test */
    function it_can_be_saved()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function it_can_be_deleted()
    {
        $this->markTestIncomplete();
    }
}
