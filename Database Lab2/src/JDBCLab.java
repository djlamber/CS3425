import java.io.Console;
import java.sql.*;

public class JDBCLab {
	Connection conn = null;
	Statement stmt = null;
	ResultSet rs = null;

	public int connectDB() {
		String username;
		char[] passwordch = null;
		String password;
		try {
			Console console = System.console();
			if (console == null) {
				System.out.println("console is null. Run the program in terminal");
				System.out.println("For example, first go to bin dir, then run"
						+ "java -cp .:/usr/share/java/mysql-connector-java.jar JDBCLab");
				return 1;
			}
			username = console.readLine("Please enter your name:");
			passwordch = console.readPassword("Please enter your password:", passwordch);
			password = String.valueOf(passwordch);
			conn = DriverManager.getConnection("jdbc:mysql://classdb.it.mtu.edu/djlamber",
					username, password);
		} catch (SQLException e) {
			System.out.println(e.getMessage());
			e.printStackTrace();
			return 1;
		}
		return 0;
	}

	public void disconnect() {
		try {
			conn.close();
		} catch (SQLException ex) {
			System.out.println("SQLException: " + ex.getMessage());
			System.out.println("SQLState: " + ex.getSQLState());
			System.out.println("VendorError: " + ex.getErrorCode());
		}
	}

	public void select() {
		Statement stmt = null;
		ResultSet rs = null;

		try {
			stmt = conn.createStatement();
			rs = stmt.executeQuery("select account_number, balance from lab2_account");

			while (rs.next()) {
				System.out.println(rs.getString(1) + "," + rs.getString(2));
			}
		} catch (SQLException ex) {
			System.out.println("SQLException: " + ex.getMessage());
			System.out.println("SQLState: " + ex.getSQLState());
			System.out.println("VendorError: " + ex.getErrorCode());
		}
	}

	public int withdraw(String account_number, double amount) {
		Statement stmt = null;
		ResultSet rs = null;
		int rowcount;

		// start transaction
		try {
			conn.setAutoCommit(false);
			conn.setTransactionIsolation(conn.TRANSACTION_SERIALIZABLE);
		} catch (SQLException e) {
			e.printStackTrace();
			return 0;
		}

		try {
			stmt = conn.createStatement();
			rowcount = stmt.executeUpdate("update lab2_account set balance = balance - " + amount +" where account_number = " + account_number);

			// check number of rows have been changed.
			if (rowcount != 1) {
				System.out.println("Something is wrong!!! You are updating " + rowcount + " rows");
				conn.rollback();
			} else {
				conn.commit();
			}
		} catch (SQLException ex) {
			// handle any errors
			System.out.println("SQLException: " + ex.getMessage());
			System.out.println("SQLState: " + ex.getSQLState());
			System.out.println("VendorError: " + ex.getErrorCode());
		}

		return 1;
	}

	public static void main(String args[]) {
		JDBCLab dblab = new JDBCLab();

		dblab.connectDB();
		dblab.select();
		dblab.withdraw("A001", 100);
		dblab.disconnect();
	}
}
