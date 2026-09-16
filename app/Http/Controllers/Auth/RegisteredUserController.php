<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Residence;
use App\Models\Building;
use App\Models\Apartment;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Notifications\ApplicationNotification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:syndic,resident'],
            'residence_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        if ($request->role === 'resident') {
            $rules['building_name'] = ['required', 'string', 'max:255'];
            $rules['apartment_number'] = ['required', 'string', 'max:50'];
            $rules['floor'] = ['required', 'integer', 'min:0'];
        }

        $request->validate($rules);

        if ($request->role === 'resident') {
            $residence = Residence::where('name', $request->residence_name)
                ->whereNotNull('syndic_id')
                ->first();

            if (!$residence) {
                throw ValidationException::withMessages([
                    'residence_name' => 'Cette résidence n’est pas encore enregistrée par un syndic.',
                ]);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if ($user->isSyndic()) {
            $residence = \App\Models\Residence::firstOrCreate(
                ['name' => $request->residence_name],
                ['address' => 'Casablanca', 'city' => 'Casablanca']
            );
            $residence->update(['syndic_id' => $user->id]);
        } else {
            $building = Building::firstOrCreate(
                [
                    'residence_id' => $residence->id,
                    'name' => $request->building_name,
                ],
                [
                    'floors_count' => max((int) $request->floor, 1),
                ]
            );

            Apartment::updateOrCreate(
                [
                    'building_id' => $building->id,
                    'number' => $request->apartment_number,
                ],
                [
                    'user_id' => $user->id,
                    'floor' => (int) $request->floor,
                    'monthly_fee' => 800.00,
                    'status' => 'occupied',
                ]
            );

            $residence->syndic?->notify(new ApplicationNotification(
                'Nouvelle inscription résident',
                $user->name . ' a rejoint ' . $residence->name . '.',
                'registration',
                route('syndic.residents')
            ));
        }

        event(new Registered($user));

        Auth::login($user);

        return $user->isSyndic()
            ? redirect()->route('syndic.dashboard')
            : redirect()->route('resident.dashboard');
    }
}
