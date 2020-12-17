@extends('layout')

@section('division')    
    @if(count($divisionsWithTeams) && isset($divisionsWithTeams['divisions']))    
        @foreach($divisionsWithTeams['divisions'] as $division)
        <table class="table-3" id="{{$division['divisionId']}}">
            <thead>
                <tr>
                <th colspan="11">Division {{$division['divisionName']}}</th>                
                </tr>
                <tr>
                <th>Teams</th>
                @foreach($division['teams'] as $team)
                <th>{{$team['teamName']}}</th>    
                @endforeach            
                <th>Score</th>            
                <th>Position</th>
                </tr>
            </thead>
            <tbody>
                @foreach($division['teams'] as $team)
                    <tr>
                        <td data-label="#">{{$team['teamName']}}</td>
                        @foreach($division['teams'] as $subteam)
                            @if($team['teamName'] === $subteam['teamName'])
                            <td id="{{$team['teamId']}}_{{$subteam['teamId']}}" class="gray">&nbsp;</td>
                            @else    
                            <td id="{{$team['teamId']}}_{{$subteam['teamId']}}">&nbsp;</td>
                            @endif                        
                        @endforeach            
                        <td id="score_{{$team['teamId']}}"></td>
                        <td id="position_{{$team['teamId']}}"></td>
                    </tr>
                @endforeach            
            </tbody>
            </table>  
            <br/>   
        @endforeach           
    @endif
@endsection

@section('playoff')    
        <table class="table-playoff" id="playoff">
            <thead>                
                <tr>
                <th colspan="2"></th>                
                <th colspan="2">Semi-final</th>                            
                <th colspan="2">Final</th>                
                <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i < 17; $i++)
                    <tr>                        
                        <td id="playoff_team_1_{{$i}}"></td>
                        <td id="playoff_game_1_{{$i}}"></td>
                        <td id="playoff_team_2_{{$i}}"></td>
                        <td id="playoff_game_2_{{$i}}"></td>
                        <td id="playoff_team_3_{{$i}}"></td>
                        <td id="playoff_game_3_{{$i}}"></td>
                        @if($team['teamName'] === $subteam['teamName'])
                            <td id="playoff_result_{{$i}}">&nbsp;</td>                        
                        @endif                        
                    </tr>
                @endfor    
            </tbody>
            </table>  
            <br/>           
@endsection

@section('javascript')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });       
        

        $('#generate').submit(function(event){
            event.preventDefault();             

            $.ajax({
                type:"GET",
                url:"/create",
                dataType: 'json',  
                success: function(data){
                    //console.log(data);
                    for (key in data['divisions']) {                        
                        var games = data['divisions'][key]['games'];
                        for (let i = 0; i < games.length; i++) {
                            var id_team1 = games[i]['idTeam1'];
                            var id_team2 = games[i]['idTeam2'];
                            var goal_team1 = games[i]['goalTeam1'];
                            var goal_team2 = games[i]['goalTeam2'];                            

                            var id_str= '#' + id_team1 + '_' + id_team2;
                            var content_str =  goal_team1+':'+goal_team2;                            

                            $(id_str).html(content_str);                            

                            var id_str= '#' + id_team2 + '_' + id_team1;
                            var content_str =  goal_team2+':'+goal_team1;
                            $(id_str).html(content_str);
                        }

                        var score = data['divisions'][key]['score'];
                        for (score_key in score) {
                            var id_str= '#score_' + score_key;
                            var content_str =  score[score_key];  

                            $(id_str).html(content_str);
                        }
                        
                        var positions = data['divisions'][key]['positions'];                        
                        
                        for (positions_key in positions) {
                            var id_str= '#position_' + positions_key;
                            var content_str =  positions[positions_key];

                            $(id_str).html(content_str);
                        }                        
                        
                        //alert(games.length);
                    }

                    for (key in data['playoff']['winners']) {                        
                        var id_str= '#playoff_result_' + key;
                        //console.log(data['playoff']['winners'][key]);
                        var idTeam = data['playoff']['winners'][key]['idTeam'];
                        var teamName = data['playoff']['teamNames'][idTeam]['teamName'];
                        var content_str =  key + '. ' + teamName;

                        $(id_str).html(content_str);
                        //console.log(data['playoff'][key]);
                    }    

                    for (key in data['playoff']['bracket']) {                        
                        for (key2 in data['playoff']['bracket'][key]) {
                            var coeff = 4;
                            var coeff1 = 1;
                            if (key == 2) {
                                coeff = 8;
                                coeff1=3;
                            }    
                            if (key == 3) {
                                coeff1 = 2*(key-1) + 1;
                            }
                            var i = coeff*(data['playoff']['bracket'][key][key2]['idGroup']-1)+coeff1;

                            if ($('#playoff_team_' + key + '_' + i).html()) {
                                i++;
                            }
                            var id_str= '#playoff_team_' + key + '_' + i;

                            var idTeam = data['playoff']['bracket'][key][key2]['idTeam'];
                            var teamName = data['playoff']['teamNames'][idTeam]['teamName'];
                            var content_str = teamName;
                            $(id_str).html(content_str);
                        }                        
                    }   

                    for (key in data['playoff']['games']) {
                        for (key2 in data['playoff']['games'][key]) {
                            var coeff = 4;
                            var coeff1 = 2;
                            if (key == 2) {
                                coeff = 8;
                                coeff1=4;
                            }    
                            if (key == 3) {
                                coeff1 = 2*(key-1) + 2;
                            }
                            var i = coeff*(data['playoff']['games'][key][key2]['idGroup']-1)+coeff1;
                            
                            var id_str= '#playoff_game_' + key + '_' + i;
                            var content_str = "" + data['playoff']['games'][key][key2]['goalTeam1'] + ':' +data['playoff']['games'][key][key2]['goalTeam2'];
                            $(id_str).html(content_str);
                        }    
                    }                   
                }
            });

        });
        
    });
    </script>    
@endsection

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}" />    
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection

@section('button')
<form id="generate" action="#">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" value="Generate" class="btn btn-primary">
</form>
@endsection