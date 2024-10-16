<?php

namespace App\Providers;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\Fine;
use App\Models\Insurance;
use App\Models\License;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\PredefinedKit;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\TowingRequest;
use App\Models\TypeOfExpence;
use App\Models\User;
use App\Policies\AccessoryPolicy;
use App\Policies\AssetAssignmentPolicy;
use App\Policies\AssetInsurancePolicy;
use App\Policies\AssetModelPolicy;
use App\Policies\AssetPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ComponentPolicy;
use App\Policies\ConsumablePolicy;
use App\Policies\CustomFieldPolicy;
use App\Policies\CustomFieldsetPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DepreciationPolicy;
use App\Policies\FinePolicy;
use App\Policies\LicensePolicy;
use App\Policies\LocationPolicy;
use App\Policies\ManufacturerPolicy;
use App\Policies\PredefinedKitPolicy;
use App\Policies\ReExpencePolicy;
use App\Policies\StatuslabelPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\TowingPolicy;
use App\Policies\TypeOfExpencePolicy;
use App\Policies\UserPolicy;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * See SnipePermissionsPolicy for additional information.
     *
     * @var array
     */
    protected $policies = [
        Accessory::class => AccessoryPolicy::class,
        Asset::class => AssetPolicy::class,
        AssetModel::class => AssetModelPolicy::class,
        Category::class => CategoryPolicy::class,
        Component::class => ComponentPolicy::class,
        Consumable::class => ConsumablePolicy::class,
        CustomField::class => CustomFieldPolicy::class,
        CustomFieldset::class => CustomFieldsetPolicy::class,
        Department::class => DepartmentPolicy::class,
        Depreciation::class => DepreciationPolicy::class,
        License::class => LicensePolicy::class,
        Location::class => LocationPolicy::class,
        PredefinedKit::class => PredefinedKitPolicy::class,
        Statuslabel::class => StatuslabelPolicy::class,
        Supplier::class => SupplierPolicy::class,
        User::class => UserPolicy::class,
        Manufacturer::class => ManufacturerPolicy::class,
        Company::class => CompanyPolicy::class,
        AssetAssignment::class => AssetAssignmentPolicy::class,
        Insurance::class => AssetInsurancePolicy::class,
        TypeOfExpence::class => TypeOfExpencePolicy::class,
        Fine::class => FinePolicy::class,
        TowingRequest::class => TowingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            \Laravel\Passport\Console\InstallCommand::class,
            \Laravel\Passport\Console\ClientCommand::class,
            \Laravel\Passport\Console\KeysCommand::class,
        ]);

        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addYears(config('passport.expiration_years')));
        Passport::refreshTokensExpireIn(Carbon::now()->addYears(config('passport.expiration_years')));
        Passport::personalAccessTokensExpireIn(Carbon::now()->addYears(config('passport.expiration_years')));
        Passport::withCookieSerialization();

        // --------------------------------
        // BEFORE ANYTHING ELSE
        // --------------------------------
        // If this condition is true, ANYTHING else below will be assumed
        // to be true. This can cause weird blade behavior.
        Gate::before(function ($user) {
            if ($user->isSuperUser()) {
                return true;
            }
        });

        // --------------------------------
        // GENERAL GATES
        // These control general sections of the admin
        // --------------------------------
        Gate::define('admin', function ($user) {
            if ($user->hasAccess('admin')) {
                return true;
            }
        });

        Gate::define('accessories.files', function ($user) {
            if ($user->hasAccess('accessories.files')) {
                return true;
            }
        });

        Gate::define('components.files', function ($user) {
            if ($user->hasAccess('components.files')) {
                return true;
            }
        });

        Gate::define('consumables.files', function ($user) {
            if ($user->hasAccess('consumables.files')) {
                return true;
            }
        });

        // Can the user import CSVs?
        Gate::define('import', function ($user) {
            if ($user->hasAccess('import')) {
                return true;
            }
        });


        Gate::define('licenses.files', function ($user) {
            if ($user->hasAccess('licenses.files')) {
                return true;
            }
        });
        // access for the dashboard
        Gate::define('dashboard', function ($user) {
            if ($user->hasAccess('dashboard')) {
                return true;
            }
        });
        // access for the reimmensible expense
        Gate::define('add_expences.view', function ($user) {
            if ($user->hasAccess('add_expences.view')) {
                return true;
            }
        });
        // access for the Towing Request
        Gate::define('towing_requests.view', function ($user) {
            if ($user->hasAccess('towing_requests.view')) {
                return true;
            }
        });
        // access for the assets handover details
        Gate::define('handover-details', function ($user) {
            if ($user->hasAccess('handover-details')) {
                return true;
            }
        });

        // -----------------------------------------
        // Reports
        // -----------------------------------------
        Gate::define('reports.view', function ($user) {
            if ($user->hasAccess('reports.view')) {
                return true;
            }
        });

        // -----------------------------------------
        // Self
        // -----------------------------------------
        Gate::define('self.two_factor', function ($user) {
            if (($user->hasAccess('self.two_factor')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('self.api', function ($user) {
            return $user->hasAccess('self.api');
        });

        Gate::define('self.edit_location', function ($user) {
            return $user->hasAccess('self.edit_location');
        });

        Gate::define('self.checkout_assets', function ($user) {
            return $user->hasAccess('self.checkout_assets');
        });

        Gate::define('self.view_purchase_cost', function ($user) {
            return $user->hasAccess('self.view_purchase_cost');
        });

        // This is largely used to determine whether to display the gear icon sidenav 
        // in the left-side navigation
        Gate::define('backend.interact', function ($user) {
            return $user->can('view', Statuslabel::class)
                || $user->can('view', AssetModel::class)
                || $user->can('view', Category::class)
                || $user->can('view', Manufacturer::class)
                || $user->can('view', Supplier::class)
                || $user->can('view', Department::class)
                || $user->can('view', Location::class)
                || $user->can('view', Company::class)
                || $user->can('view', Manufacturer::class)
                || $user->can('view', CustomField::class)
                || $user->can('view', CustomFieldset::class)
                || $user->can('view', Depreciation::class);
        });


        // This  determines whether or not an API user should be able to get the selectlists.
        // This can seem a little confusing, since view properties may not have been granted
        // to the logged in API user, but creating assets, licenses, etc won't work 
        // if the user can't view and interact with the select lists.
        Gate::define('view.selectlists', function ($user) {
            return $user->can('update', Asset::class)
                || $user->can('create', Asset::class)
                || $user->can('checkout', Asset::class)
                || $user->can('checkin', Asset::class)
                || $user->can('audit', Asset::class)
                || $user->can('update', License::class)
                || $user->can('create', License::class)
                || $user->can('update', Component::class)
                || $user->can('create', Component::class)
                || $user->can('update', Consumable::class)
                || $user->can('create', Consumable::class)
                || $user->can('update', Accessory::class)
                || $user->can('create', Accessory::class)
                || $user->can('update', User::class)
                || $user->can('create', User::class);
        });
    }
}
