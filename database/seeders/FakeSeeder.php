<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Types\Seeder;
use App\Models\Member;
use App\Models\School;
use App\Storage\Image;
use App\Models\Article;
use App\Models\Project;
use App\Models\Vacancy;
use App\Models\Workplace;
use App\Models\Invitation;
use App\Models\Requirement;
use App\Models\Organization;
use App\Models\Subscription;
use Laravel\Paddle\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Sequence;

class FakeSeeder extends Seeder
{
    /**
     * The identifiers of the articles.
     *
     */
    protected Collection $articles;

    /**
     * The maximum numbers of models to generate.
     *
     */
    protected object $limits;

    /**
     * The identifiers of the organizations.
     *
     */
    protected Collection $organizations;

    /**
     * The identifiers of the tools.
     *
     */
    protected Collection $tools;

    /**
     * The identifiers of the users.
     *
     */
    protected Collection $users;

    /**
     * The identifiers of the vacancies.
     *
     */
    protected Collection $vacancies;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->tools         = Tool::pluck('id');
        $this->users         = collect();
        $this->articles      = collect();
        $this->projects      = collect();
        $this->vacancies     = collect();
        $this->organizations = collect();

        $this->limits = (object) [
            'users'         => (int) env('TEST_SEED_USERS', 100),
            'organizations' => (int) env('TEST_SEED_ORGANIZATIONS', 10),
        ];
    }

    /**
     * Seed the application database.
     *
     */
    public function run() : void
    {
        if (app()->isProduction()) {
            return;
        }

        $this->seed('Organizations');
        $this->seed('Subscriptions');
        $this->seed('Users');
        $this->seed('Members');
        $this->seed('Skills');
        $this->seed('Schools');
        $this->seed('Workplaces');
        $this->seed('Vacancies');
        $this->seed('Requirements');
        $this->seed('Invitations');
        $this->seed('Projects');
        $this->seed('Articles');
    }

    /**
     * Populate the database with fake articles.
     *
     */
    protected function seedArticles() : void
    {
        $this->users->each(function($user) {
            Article::factory()
                ->count(3)
                ->sequence(fn() => [
                    'user_id'    => $user,
                    'created_at' => now()->subMinutes(rand(0, 4800)),
                ])
                ->create()
                ->each(fn($article) => $this->articles->push($article->id));
        });
    }

    /**
     * Populate the database with fake invitations.
     *
     */
    protected function seedInvitations() : void
    {
        $index = 0;

        $this->vacancies->each(function($vacancy) use (&$index) {
            Invitation::factory()
                ->count(4)
                ->state(new Sequence([
                    'vacancy_id'      => $vacancy->id,
                    'organization_id' => $vacancy->organization,
                    'user_id'         => $this->users[$index],
                ], [
                    'vacancy_id'      => $vacancy->id,
                    'organization_id' => $vacancy->organization,
                    'user_id'         => $this->users[$index + 1],
                ], [
                    'vacancy_id'      => $vacancy->id,
                    'organization_id' => $vacancy->organization,
                    'user_id'         => $this->users[$index + 2],
                ], [
                    'vacancy_id'      => $vacancy->id,
                    'organization_id' => $vacancy->organization,
                    'user_id'         => $this->users[$index + 3],
                ]))
                ->create();

            $index = $this->updateIndex('users', $index, 4);
        });
    }

    /**
     * Populate the database with fake members.
     *
     */
    protected function seedMembers() : void
    {
        $index = 0;

        $this->organizations->each(function($organization) use (&$index) {
            Member::factory()
                ->count(3)
                ->state(new Sequence([
                    'organization_id' => $organization,
                    'user_id'         => $this->users[$index],
                    'role'            => Member::ROLE_MANAGER,
                ], [
                    'organization_id' => $organization,
                    'user_id'         => $this->users[$index + 1],
                    'role'            => Member::ROLE_ASSOCIATE,
                ], [
                    'organization_id' => $organization,
                    'user_id'         => $this->users[$index + 2],
                    'role'            => Member::ROLE_ASSOCIATE,
                ]))
                ->create();

            $index = $this->updateIndex('users', $index, 3);
        });
    }

    /**
     * Populate the database with fake organizations.
     *
     */
    protected function seedOrganizations() : void
    {
        for ($i = 0; $i < $this->limits->organizations; $i++) {
            $this->organizations->push(Organization::factory()->create()->id);
        }

        Organization::first()->update([
            'name'  => env('TEST_ORGANIZATION_NAME', 'Acme Products'),
            'email' => env('TEST_ORGANIZATION_EMAIL', 'contact@acme.com'),
        ]);
    }

    /**
     * Populate the database with fake projects.
     *
     */
    protected function seedProjects() : void
    {
        $this->users->each(function($user) {
            Project::factory()
                ->count(3)
                ->create([
                    'user_id' => $user,
                    'logo'    => null,
                ])
                ->each(fn($project) => $this->projects->push([
                    'id'      => $project->id,
                    'user_id' => $project->user_id,
                ]));
        });
    }

    /**
     * Populate the database with fake requirements.
     *
     */
    protected function seedRequirements() : void
    {
        $this->vacancies->each(function($vacancy) {
            $this->tools->random(10)->each(function($tool) use (&$vacancy) {
                Requirement::factory()->create([
                    'tool_id'         => $tool,
                    'vacancy_id'      => $vacancy->id,
                    'organization_id' => $vacancy->organization,
                ]);
            });
        });
    }

    /**
     * Populate the database with fake schools.
     *
     */
    protected function seedSchools() : void
    {
        $this->users->each(function($user) {
            School::factory()
                ->count(3)
                ->state(new Sequence([
                    'user_id'       => $user,
                    'qualification' => School::QUALIFICATION_CERTIFICATE,
                    'started_at'    => $start_1 = now()->subDays(rand(2000, 3000)),
                    'finished_at'   => $finish_1 = $start_1->addDays(rand(365, 1500)),
                ], [
                    'user_id'       => $user,
                    'qualification' => School::QUALIFICATION_BACHELOR_DEGREE,
                    'started_at'    => $start_2 = $finish_1->addDay(),
                    'finished_at'   => $finish_2 = $start_2->addDays(rand(365, 1500)),
                ], [
                    'user_id'       => $user,
                    'qualification' => School::QUALIFICATION_MASTERS_DEGREE,
                    'started_at'    => $finish_2->addDay(),
                    'finished_at'   => now()->subDays(400),
                ]))
                ->create();
        });
    }

    /**
     * Populate the database with fake skills.
     *
     */
    protected function seedSkills() : void
    {
        $this->users->each(function($user) {
            $this->tools->random(10)->each(function($tool) use (&$user) {
                Skill::factory()->create([
                    'user_id' => $user,
                    'tool_id' => $tool,
                ]);
            });
        });
    }

    /**
     * Populate the database with fake subscriptions.
     *
     */
    public function seedSubscriptions() : void
    {
        $this->organizations->each(function($organization, $index) {
            Subscription::factory()->create([
                'billable_id'   => $organization,
                'paddle_status' => Subscription::STATUS_ACTIVE,
                'paddle_plan'   => env('TEST_SUBSCRIPTION_PADDLE_PLAN', 25423),
                'paddle_id'     => $index + 1,
            ]);
        });

        Subscription::first()->update([
            'paddle_id' => env('TEST_SUBSCRIPTION_PADDLE_ID', 1),
        ]);

        Customer::query()->update(['trial_ends_at' => now()->addYear()]);
    }

    /**
     * Populate the database with fake users.
     *
     */
    protected function seedUsers() : void
    {
        for ($i = 0; $i < $this->limits->users; $i++) {
            $this->users->push(User::factory()->create()->id);
        }

        $user = tap(User::first())->update([
            'type'   => User::TYPE_EMPLOYEE,
            'name'   => env('TEST_USER_NAME', 'John Doe'),
            'handle' => env('TEST_USER_HANDLE', 'john'),
            'email'  => env('TEST_USER_EMAIL', 'john@acme.com'),
        ]);

        Image::put($user->avatar, File::get(public_path('img/user.jpg')));
    }

    /**
     * Populate the database with fake vacancies.
     *
     */
    protected function seedVacancies() : void
    {
        $this->organizations->each(function($organization) {
            Vacancy::factory()
                ->count(4)
                ->create(['organization_id' => $organization])
                ->each(fn($vacancy) => $this->vacancies->push((object) [
                    'id'           => $vacancy->id,
                    'organization' => $organization,
                ]));
        });
    }

    /**
     * Populate the database with fake workplaces.
     *
     */
    protected function seedWorkplaces() : void
    {
        $this->users->each(function($user) {
            Workplace::factory()
                ->count(3)
                ->state(new Sequence([
                    'user_id'     => $user,
                    'started_at'  => $start_1  = now()->subDays(rand(2000, 3000)),
                    'finished_at' => $finish_1 = $start_1->addDays(rand(365, 1500)),
                ], [
                    'user_id'     => $user,
                    'started_at'  => $start_2  = $finish_1->addDay(),
                    'finished_at' => $finish_2 = $start_2->addDays(rand(365, 1500)),
                ], [
                    'user_id'     => $user,
                    'started_at'  => $finish_2->addDay(),
                    'finished_at' => null,
                ]))
                ->create();
        });
    }

    /**
     * Calculate the correct increment to an index to prevent overflow.
     *
     */
    protected function updateIndex(string $key, int $current, int $step) : int
    {
        return ($current + $step + $step) > $this->limits->{$key} ? 0 : $current + $step;
    }
}
