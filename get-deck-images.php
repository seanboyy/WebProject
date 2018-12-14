<?php

	$conn = mysqli_connect('localhost', 'root', '', 'card_database');
	if($conn->connect_errno){
		echo("failed to connect!");
	}
	else{
		$result = $conn->query("SELECT card_id, card_image FROM `custom_cards` ");
		$reversed = array_reverse($result->fetch_all());
		for($i = 0; $i < count($reversed); ++$i){
			echo ("<span class='deckSpan' style='display:inline-block'>
				<table>
					<tbody>
						<tr>
							<td>
								<table>
									<tbody>
										<tr>
											<td>"
												.$reversed[$i][0].
											"</td>
										</tr>
										<tr>
											<td>
												<a href='./deck-view.php?id=".$reversed[$i][1]."'>
													<img alt='".$reversed[$i][1]."' src='".explode(' ', $reversed[$i][2])[0]."' class='cardFormat'/>
												</a>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td>
								<table>
									<tbody>
										<tr>
											<td class='upvoteButton'>
												<input class=\"vote\" type='button' onclick='doUpvote(".$reversed[$i][1].")' value='Upvote'/>
											</td>
										</tr>
										<tr>
											<td id=dpu".$reversed[$i][1].">"
												.$reversed[$i][3].
											"</td>
										</tr>
										<tr>
											<td class='downvoteButton'>
												<input class=\"vote\" type='button' onclick='doDownvote(".$reversed[$i][1].")' value='Downvote'/>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</span>");
		}
	}
?>