<div class="card pub-image">
    <div class="card-header">
        @if($image->user->image)
        <div class="container-avatar">
            <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar" />
        </div>
        @endif
        <div class="data-user">
            <a href="{{ route('user.profile', ['id' => $image->user->id]) }}">
                {{ $image->user->name . ' ' . $image->user->surname }}
                <span class="nickname">
                    {{ ' | @' . $image->user->nick }}
                </span>
            </a>
        </div>
    </div>

    <div class="card-body ">
        <div class="image-container">
            <img src="{{ route('image.file', ['filename' => 
            $image->image_path]) }}" />
        </div>
        <div class="likes"></div>
        <div class="description">
            <span class="nickname">
                {{ '@' . $image->user->nick }}
            </span>
            <span class="nickname date">
                {{ ' | ' . \FormatTime::LongTimeFilter($image->created_at) }}
            </span>
            <p>{{ $image->description }}</p>
        </div>
        
        <div class="likes">
            <?php $user_like = false; ?>

            @foreach($image->likes as $like)
                @if($like->user->id == Auth::user()->id)
                    <?php $user_like = true; ?>
                @endif
            @endforeach
            @if($user_like)
                <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $image->id }}" class="btn-like" />
            @else
                <img src="{{ asset('img/heart-black.png') }}" data-id="{{ $image->id }}" class="btn-dislike" />
            @endif

            <span class="number-likes">{{ count($image->likes) }}</span>
        </div>

        <div class="comments">
            <a class="btn btn-sm btn-warning btn-comments" href="{{ route('image.detail', ['id' => $image->id]) }}">
                Comentarios ({{ count($image->comments) }})
            </a>
        </div>
    </div>
</div>