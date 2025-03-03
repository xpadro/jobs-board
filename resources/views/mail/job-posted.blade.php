<h2>
    {{ $job->title }}
</h2>

<p>
    Your job has been posted in our website
</p>

<p>
    <!-- Provide the full app url since it is being seen in the email -->
    <a href="{{ url('/jobs/' . $job->id) }}">View your job listing</a>
</p>