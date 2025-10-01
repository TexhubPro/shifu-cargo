<?php

namespace App\Livewire\MiniApp;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use DefStudio\Telegraph\Facades\Telegraph;

class Profile extends Component
{
    public $avatar;
    public function mount($id = null)
    {
        if (Auth::check()) {
        } else {
            $user = User::where('chat_id', $id)->first();
            if (!$user) {
                return redirect()->route('register');
            }
            Auth::login($user, true);
        }
        $id_user = $user->chat_id ?? '1039537210';
        $response = file_get_contents("https://api.telegram.org/bot8407155944:AAG8fIkZS5AXDWgDu69boaAK_g1aoWt4o5c/getUserProfilePhotos?user_id={$id_user}");
        $data = json_decode($response, true);

        if ($data['result']['total_count'] > 0) {
            $fileId = $data['result']['photos'][0][0]['file_id']; // первый размер первой фотографии
        } else {
            $fileId = null;
        }
        if ($fileId) {
            $response = file_get_contents("https://api.telegram.org/bot8407155944:AAG8fIkZS5AXDWgDu69boaAK_g1aoWt4o5c/getFile?file_id={$fileId}");
            $fileData = json_decode($response, true);

            $filePath = $fileData['result']['file_path'];
            $avatarUrl = "https://api.telegram.org/file/bot8407155944:AAG8fIkZS5AXDWgDu69boaAK_g1aoWt4o5c/{$filePath}";

            $this->avatar = $avatarUrl;
        } else {
            $this->avatar = null;
        }
    }
    public function render()
    {
        return view('livewire.mini-app.profile');
    }
}
