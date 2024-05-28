<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProfileController extends Controller {

    /**
     * Показывает список всех профилей
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $profiles = auth()->user()->profiles()->with('supplier')->paginate(4);
        return view('user.profile.index', compact('profiles'));
    }    

    /**
     * Возвращает данные профиля в формате JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        // TODO: здесь нужна какая-никакая проверка
        $profile = self::findOrFail();
        return response()->json($profile);
    }

    /**
     * Показывает форму для создания профиля
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $suppliers = Supplier::all();
        $user = auth()->user();
        return view('user.profile.create', compact('suppliers', 'user'));
    }    

    /**
     * Сохраняет новый профиль в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = auth()->user();
        $this->validate($request, [
            'user_id' => 'in:' . $user->id,
            'title' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);
    
        $profileData = $request->all();
        $profileData['name'] = $user->name;
        $profileData['email'] = $user->email;
    
        $profile = Profile::create($profileData);
    
        return redirect()
            ->route('user.profile.show', ['profile' => $profile->id])
            ->with('success', 'Новый профиль успешно создан');
    }    

    /**
     * Показывает информацию о профиле
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile) {
        if ($profile->user_id !== auth()->user()->id) {
            abort(404); // это чужой профиль
        }
        $profile->load('supplier'); // Загрузка связанного поставщика
        return view('user.profile.show', compact('profile'));
    }    

    /**
     * Показывает форму для редактирования профиля
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile) {
        if ($profile->user_id !== auth()->user()->id) {
            abort(404); // это чужой профиль
        }
        $suppliers = Supplier::all();
        $user = auth()->user();
        return view('user.profile.edit', compact('profile', 'suppliers', 'user'));
    }    

    /**
     * Обновляет профиль (запись в таблице БД)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile) {
        $user = auth()->user();
        $this->validate($request, [
            'user_id' => 'in:' . $user->id,
            'title' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);
    
        $profileData = $request->all();
        $profileData['name'] = $user->name;
        $profileData['email'] = $user->email;
    
        $profile->update($profileData);
    
        return redirect()
            ->route('user.profile.show', ['profile' => $profile->id])
            ->with('success', 'Профиль был успешно отредактирован');
    }
    

    /**
     * Удаляет профиль (запись в таблице БД)
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile) {
        if ($profile->user_id !== auth()->user()->id) {
            abort(404); // это чужой профиль
        }
        $profile->delete();
        return redirect()
            ->route('user.profile.index')
            ->with('success', 'Профиль был успешно удален');
    }
}
