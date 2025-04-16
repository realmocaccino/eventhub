<?php
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('index returns paginated events', function () {
    Event::factory()->count(15)->create();
    
    $response = $this->get(route('events.index'));
    
    $response->assertInertia(fn ($page) => $page
        ->component('Events/Index')
        ->has('events.data', 10)
    );
});

test('store creates event', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    Storage::fake('public');
    
    $data = handleDatetimeFields(Event::factory()->raw());
    $data['image'] = UploadedFile::fake()->image('event.jpg');
    
    $this->post(route('events.store'), $data);
    
    $this->assertDatabaseHas('events', [
        'title' => $data['title'],
        'location' => $data['location']
    ]);
    
    Storage::disk('public')->assertExists('events/'.$data['image']->hashName());
});

test('store requires valid data', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    $invalidData = handleDatetimeFields(Event::factory()->raw([
        'title' => '',
        'location' => '',
    ]));
    
    $response = $this->post(route('events.store'), $invalidData);
    
    $response->assertSessionHasErrors(['title', 'location']);
});

test('displays event with registration status', function () {
    $event = Event::factory()->create();
    
    $response = $this->get(route('events.show', $event));
    
    $response->assertInertia(fn ($page) => $page
        ->component('Events/Show')
        ->where('event.id', $event->id)
        ->where('registered', false)
    );
});

test('indicates when user is registered', function () {
    $event = Event::factory()->create();
    $this->user->events()->attach($event);
    
    $response = $this->get(route('events.show', $event));
    
    $response->assertInertia(fn ($page) => $page
        ->where('registered', true)
    );
});

test('updates event', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    $event = Event::factory()->create([
        'image' => null
    ]);
    $newData = handleDatetimeFields(Event::factory([
        'image' => null
    ])->raw());

    $response = $this->post(route('events.update', $event), $newData);
    
    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'title' => $newData['title']
    ]);
});

test('destroys event', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    $event = Event::factory()->create();
    
    $this->delete(route('events.destroy', $event));
    
    $this->assertDatabaseMissing('events', ['id' => $event->id]);
});

test('manage events with filters', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);
    
    Event::factory()->count(5)->create();

    $response = $this->get(route('events.manage'));
    
    $response->assertInertia(fn ($page) => $page
        ->component('Events/Manage')
        ->has('events.data', 5)
    );
});

test('guest cannot access protected routes', function () {
    auth()->logout();
    $event = Event::factory()->create();
    
    $this->get(route('events.create'))->assertRedirect(route('login'));
    $this->post(route('events.store'), [])->assertRedirect(route('login'));
    $this->get(route('events.edit', $event))->assertRedirect(route('login'));
    $this->post(route('events.update', $event), [])->assertRedirect(route('login'));
    $this->delete(route('events.destroy', $event))->assertRedirect(route('login'));
});

test('admin sees manage view differently', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);
    
    $response = $this->get(route('events.manage'));
    
    $response->assertInertia(fn ($page) => $page
        ->component('Events/Manage')
    );
});