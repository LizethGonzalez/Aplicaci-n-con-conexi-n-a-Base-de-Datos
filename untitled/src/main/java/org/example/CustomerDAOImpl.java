package org.example;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class CustomerDAOImpl implements CustomerDAO {
    private Connection connection;

    public CustomerDAOImpl(Connection connection) {
        this.connection = connection;
    }

    public void add(Customer customer) throws SQLException {
        String sql = "INSERT INTO customers (customer_id, email_address, full_name) VALUES (?, ?, ?)";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setLong(1, customer.customerId());
            stmt.setString(2, customer.emailAddress());
            stmt.setString(3, customer.fullName());
            stmt.executeUpdate();
        }
    }

    public Customer getById(Long customerId) throws SQLException {
        String sql = "SELECT * FROM customers WHERE customer_id = ?";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setLong(1, customerId);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                return new Customer(
                        rs.getLong("customer_id"),
                        rs.getString("email_address"),
                        rs.getString("full_name")
                );
            }
        }
        return null;
    }

    public List<Customer> getAll() throws SQLException {
        List<Customer> customers = new ArrayList<>();
        String sql = "SELECT * FROM customers ";
        try (PreparedStatement stmt = connection.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {
            while (rs.next()) {
                customers.add(new Customer(
                        rs.getLong("customer_id"),
                        rs.getString("email_address"),
                        rs.getString("full_name")
                ));
            }
        }
        return customers;
    }

    public void update(Customer customer) throws SQLException {
        String sql = "UPDATE customers SET email_address = ?, full_name = ? WHERE customer_id = ?";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setString(1, customer.emailAddress());
            stmt.setString(2, customer.fullName());
            stmt.setLong(3, customer.customerId());
            stmt.executeUpdate();
        }
    }

    public void delete(Long customerId) throws SQLException {
        String sql = "DELETE FROM customers WHERE customer_id = ?";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setLong(1, customerId);
            stmt.executeUpdate();
        }
    }
}
