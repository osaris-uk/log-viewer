<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Log Viewer</title>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">{{ $currentLog }}</div>

                        <div class="card-body">
                            {{ $log->links() }}

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Level</th>
                                        <th scope="col">Env</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($log as $key => $entry)
                                        <tr>
                                            <td nowrap><span class="badge badge-{{ $colors[$entry['level']] }}">{{ $entry['level'] }}</span></td>
                                            <td nowrap>{{ $entry['env'] }}</td>
                                            <td nowrap>{{ $entry['time'] }}</td>
                                            <td><code>{{ $entry['info'] }}</code></td>
                                            <td>@if($entry['trace'])<button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target=".trace-{{ $key }}">Stack Trace</button>@endif</td>
                                        </tr>
                                        <tr class="trace-{{ $key }} collapse" aria-expanded="false">
                                            <td colspan="5">
                                                <div class="card">
                                                    <div class="card-body" style="white-space: pre-wrap;">
                                                        <code>{{ $entry['trace'] }}</code>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $log->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header px-3">
                            Last 20 Logs
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($allLogs as $log)
                            <small>
                                <a href="{{ route('log.index', $log) }}" class="list-group-item list-group-item-action px-3 {{ $log == $currentLog ? 'font-weight-bold' : '' }}">
                                    {{ $log }}
                                </a>
                            </small>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>