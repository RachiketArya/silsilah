@extends('layouts.user-profile-wide')

@section('subtitle', trans('app.family_tree'))

@section('user-content')

<?php
$childsTotal = 0;
$grandChildsTotal = 0;
$ggTotal = 0;
$ggcTotal = 0;
$ggccTotal = 0;
?>

<div id="wrapper">
    <span class="label {{ $user->gender }}">{{ link_to_route('users.show', $user->name, [$user->id], ['title' => $user->name.' ('.$user->gender.')']) }}
        @if($spouse = $user->currentSpouse())
        <span style="color: #818c91"><br>({{ link_to_route('users.show', $spouse->name, [$spouse->id], ['title' => $spouse->name.' ('.$spouse->gender.')']) }})</span>
        @endif
    </span>
        @if ($childsCount = $user->childs->count())
        <?php $childsTotal += $childsCount ?>
        <div class="branch lv1">
            @foreach($user->childs as $child)
            <div class="entry {{ $childsCount == 1 ? 'sole' : '' }}">
                <span class="label {{ $child->gender }}">{{ link_to_route('users.show', $child->name, [$child->id], ['title' => $child->name.' ('.$child->gender.')']) }}
                    @if($childSpouse = $child->currentSpouse())
                    <span style="color: #818c91"><br>({{ link_to_route('users.show', $childSpouse->name, [$childSpouse->id], ['title' => $childSpouse->name.' ('.$childSpouse->gender.')']) }})</span>
                    @endif
                </span>
                @if ($grandsCount = $child->childs->count())
                <?php $grandChildsTotal += $grandsCount ?>
                <div class="branch lv2">
                    @foreach($child->childs as $grand)
                    <div class="entry {{ $grandsCount == 1 ? 'sole' : '' }}">
                        <span class="label {{ $grand->gender }}">{{ link_to_route('users.show', $grand->name, [$grand->id], ['title' => $grand->name.' ('.$grand->gender.')']) }}
                            @if($grandSpouse = $grand->currentSpouse())
                            <span style="color: #818c91"><br>({{ link_to_route('users.show', $grandSpouse->name, [$grandSpouse->id], ['title' => $grandSpouse->name.' ('.$grandSpouse->gender.')']) }})</span>
                            @endif
                        </span>
                        @if ($ggCount = $grand->childs->count())
                        <?php $ggTotal += $ggCount ?>
                        <div class="branch lv3">
                            @foreach($grand->childs as $gg)
                            <div class="entry {{ $ggCount == 1 ? 'sole' : '' }}">
                                <span class="label {{ $gg->gender }}">{{ link_to_route('users.show', $gg->name, [$gg->id], ['title' => $gg->name.' ('.$gg->gender.')']) }}
                                    @if($ggSpouse = $gg->currentSpouse())
                                    <span style="color: #818c91"><br>({{ link_to_route('users.show', $ggSpouse->name, [$ggSpouse->id], ['title' => $ggSpouse->name.' ('.$ggSpouse->gender.')']) }})</span>
                                    @endif
                                </span>
                                @if ($ggcCount = $gg->childs->count())
                                <?php $ggcTotal += $ggcCount ?>
                                <div class="branch lv4">
                                    @foreach($gg->childs as $ggc)
                                    <div class="entry {{ $ggcCount == 1 ? 'sole' : '' }}">
                                        <span class="label {{ $ggc->gender }}">{{ link_to_route('users.show', $ggc->name, [$ggc->id], ['title' => $ggc->name.' ('.$ggc->gender.')']) }}
                                            @if($ggcSpouse = $ggc->currentSpouse())
                                            <span style="color: #818c91"><br>({{ link_to_route('users.show', $ggcSpouse->name, [$ggcSpouse->id], ['title' => $ggcSpouse->name.' ('.$ggcSpouse->gender.')']) }})</span>
                                            @endif
                                        </span>
                                        @if ($ggccCount = $ggc->childs->count())
                                        <?php $ggccTotal += $ggccCount ?>
                                        <div class="branch lv5">
                                            @foreach($ggc->childs as $ggcc)
                                            <div class="entry {{ $ggccCount == 1 ? 'sole' : '' }}">
                                                <span class="label {{ $ggcc->gender }}">{{ link_to_route('users.show', $ggcc->name, [$ggcc->id], ['title' => $ggcc->name.' ('.$ggcc->gender.')']) }}
                                                    @if($ggccSpouse = $ggcc->currentSpouse())
                                                    <span style="color: #818c91"><br>({{ link_to_route('users.show', $ggccSpouse->name, [$ggccSpouse->id], ['title' => $ggccSpouse->name.' ('.$ggccSpouse->gender.')']) }})</span>
                                                    @endif
                                                </span>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<div class="container">
<hr>
<div class="row">
    <div class="col-md-1">&nbsp;</div>
    @if ($childsTotal)
    <div class="col-md-1 text-right">{{ trans('app.child_count') }}</div>
    <div class="col-md-1 text-left"><strong style="font-size:30px">{{ $childsTotal }}</strong></div>
    @endif
    @if ($grandChildsTotal)
    <div class="col-md-1 text-right">{{ trans('app.grand_child_count') }}</div>
    <div class="col-md-1 text-left"><strong style="font-size:30px">{{ $grandChildsTotal }}</strong></div>
    @endif
    @if ($ggTotal)
    <div class="col-md-1 text-right">{{ trans('app.ggrand_child_count') }}</div>
    <div class="col-md-1 text-left"><strong style="font-size:30px">{{ $ggTotal }}</strong></div>
    @endif
    @if ($ggcTotal)
    <div class="col-md-1 text-right">{{ trans('app.g3rand_child_count') }}</div>
    <div class="col-md-1 text-left"><strong style="font-size:30px">{{ $ggcTotal }}</strong></div>
    @endif
    @if ($ggccTotal)
    <div class="col-md-1 text-right">{{ trans('app.g4rand_child_count') }}</div>
    <div class="col-md-1 text-left"><strong style="font-size:30px">{{ $ggccTotal }}</strong></div>
    @endif
    <div class="col-md-1">&nbsp;</div>
</div>
@endsection

@section ('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection
