<?php declare(strict_types=1);

namespace App\Providers;

use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Laravel\Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Premise Software Solutions, Inc.',
        'product' => 'ezSlot',
        'street' => '13400 Montview Drive',
        'location' => 'Austin, TX 78732',
        'phone' => '408-315-5978',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'jones_rich@yahoo.com';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'jones_rich@yahoo.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     */
    public function booted()
    {
        Spark::useStripe()->noCardUpFront()->trialDays(10);

        Spark::freePlan()
            ->features([
                'First', 'Second', 'Third',
            ]);

        Spark::plan('Basic', 'spark01-basic')
            ->price(10)
            ->features([
                'First', 'Second', 'Third',
            ]);
    }
}
