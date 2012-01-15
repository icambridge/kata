
class Game {

	val layout = Array(
		Array("","",""),
		Array("","",""),
		Array("","","")
	);
	
	var winner = "";
	var lastPlayer = "";

	def move( col: Int,  row: Int, marker: String) {
		if ( marker != "x" && marker != "o" ) {
			throw new IllegalArgumentException("Only values x and o");
		}
		
		if ( !layout.isDefinedAt(row) ) {
			throw new IllegalArgumentException("Invalid column");
		}
		
		if ( !layout(row).isDefinedAt(col) ) {
			throw new IllegalArgumentException("invalid row");
		}
		
		if ( layout(row)(col) != "" ) {
			throw new IllegalArgumentException("Already taken");
		}
		
		layout(row)(col) = marker;
		showLayout();
		isWon();
		lastPlayer = marker;
	}

	def isWon() {
		Array("x","o").foreach { char =>
			for (col <- 0 to 2) {
				if (layout(col)(0) == char &&
					layout(col)(1) == char &&
					layout(col)(2) == char){
					winner = char;
				}
			}
			
			for (row <- 0 to 2) {
				if (layout(0)(row) == char &&
					layout(1)(row) == char &&
					layout(2)(row) == char){
					winner = char;
				}
			}
						
			for (row <- 0 to 2) {
				if (layout(0)(0) == char &&
					layout(1)(1) == char &&
					layout(2)(2) == char){
					winner = char;
				}
			}
						
			for (row <- 0 to 2) {
				if (layout(0)(2) == char &&
					layout(1)(1) == char &&
					layout(2)(0) == char){
					winner = char;
				}
			}
				
		}
		
	}
	
	def showLayout() {
		println("Board now Looks like");
		println("+-+-+-+");
		layout.foreach { col =>
			col.foreach { row =>
				if (row != "") {
					print("|"+row);
				} else {
					print("|.");
				}
			}
			println("|");
			println("+-+-+-+");
		}
	
	}
	
	def getUserInput() {
		
		var marker = "";
		if (lastPlayer == "" || lastPlayer == "o") {
			marker = "x";
		} else {
			marker = "o";
		}
		println(marker + " you're up!");
		print("Which col do you want to use? ");
		val col = Console.readInt;
		print("Which row do you want to use? ");
		val row = Console.readInt;
		try { 
			move(col,row,marker);
		} catch {
		case e: Exception =>
			if (marker == "x") {
				winner = "o";
			} else {
				winner = "x";
			}
			println("Invalid move you lose");
		}
	}
}

val game = new Game;
while(game.winner == "") {
	game.getUserInput();
}
println("Winner is "+game.winner);