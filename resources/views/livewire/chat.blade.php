<!-- DATA table -->

<section class="section3 PrintingPage ChatPage container">
    <div class="row">
        <div class="col-md-3 chatsSection">
            <div class="titleAndNotifcation">
                <div class="title">Chats</div>
                <div class="icon">
                    <div class="icon"><i class="fa-solid fa-bell" style="color: #ffc107;"></i></div>
                    <span class="cum"></span>
                </div>
            </div>
            <div class="searchChats">
                <img src="{{ asset('admin/images/icons/search.png') }}" alt="">
                <label for="searchIcon">
                    <input type="text" class="searchBar" placeholder="Search..." id="searchIcon"
                        wire:model.live="search">
                </label>
            </div>

            <div class="ppls">
                @forelse ($this->users as $key => $user)
                    @if ($user->id != auth()->user()->id)
                        <div class="ppl {{ $user->id == $to ? 'bg-light bg-gradient' : '' }}"
                            wire:click="updateTo({{ $user->id }})">
                            <div class="image"><img src="{{ asset('admin/images/ppl/d-Avatar.png') }}" alt="">
                            </div>
                            <div class="nameAndmsg">
                                <div class="time">10:49 AM</div>
                                <div class="name">{{ $user->name }}</div>
                                <div class="msg">lsaokdlasd ....</div>
                                {{-- <div class="nummsg">2</div> --}}
                            </div>
                        </div>
                    @endif

                @empty
                    <div>no users</div>
                @endforelse
            </div>
        </div>
        {{-- wire:poll.500ms .bg-light.bg-gradient --}}
        <div class="col-md-9 mainChats" wire:poll.700ms>
            @if ($user_to)

                <div class="containerChats animate__animated animate__rotateInDownLeft">
                    <div class="chatUser">
                        <div class="image"><img src="{{ asset('admin/images/ppl/d-Avatar.png') }}" alt="">
                        </div>
                        <div class="name">{{ $user_to->name }} </div>
                    </div>
                    <div id="CContainerOfMesseges"
                        class="containerOfMesseges container animate__animated animate__bounceIn animate__delay-1s">
                        @forelse ($massage as $item)
                            @if ($item->user_id == auth()->user()->id && $item->to == $to)
                                <div class="containerMessageUser">
                                    <div class="messageUser">
                                        <div class="userNAme">{{ auth()->user()->name }} </div>
                                        <div class="message">{{ $item->massage_text }}</div>

                                        <div class="time">{{ $item->created_at }}</div>
                                    </div>
                                </div>
                            @endif
                            @if ($item->to == auth()->user()->id && $item->user_id == $to)
                                <div class="messageSender">
                                    <div class="userNAme">{{ $user_to->name }}</div>
                                    <div class="message">{{ $item->massage_text }}</div>
                                    <div class="time">{{ $item->created_at }}</div>
                                </div>
                            @endif
                        @empty
                            <div>no massage</div>
                        @endforelse


                    </div>
                    <form wire:submit.prevent="sendMessage">
                        <div class="writeMessageSection">
                            <input class="writing" type="text" placeholder="Write a message..."
                                wire:model.defer="massageText" required>
                            <input type="hidden" wire:model.defer="to">
                            <button type="submit" class="btn massageTextBtn" onclick="funclick()">Send</button>
                        </div>
                    </form>



                </div>
            @endif
        </div>
    </div>
</section>
