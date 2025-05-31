package org.example;

public record Customer(
        Long customerId,
        String emailAddress,
        String fullName
) {
}

