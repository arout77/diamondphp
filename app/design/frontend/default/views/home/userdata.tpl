<table class="table">
	<th>Username</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>DOB</th>

	<tbody>
		{foreach $users as $user}
			<tr>
				<td>{$user.username}</td>
				<td>{$user.first_name}</td>
				<td>{$user.last_name}</td>
				<td>{$user.dob}</td>
			</tr>
		{/foreach}
	</tbody>
</table>